<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = trim(Str::limit((string) $request->query('q', ''), 100, ''));
        $categorySlug = Str::slug((string) $request->query('category', ''));
        $category = $categorySlug === '' ? null : Category::query()
            ->where('status', true)
            ->where(fn ($builder) => $builder->where('slug', $categorySlug)
                ->orWhereRaw('LOWER(name) = ?', [str_replace('-', ' ', $categorySlug)]))
            ->first();

        $sort = in_array($request->query('sort'), ['newest', 'price_asc', 'price_desc'], true)
            ? $request->query('sort') : 'relevance';

        $productsQuery = $this->availableProducts()
            ->with(['category', 'variants' => fn ($builder) => $builder->where('is_active', true)->orderBy('id')])
            ->withCount(['variants' => fn ($builder) => $builder->where('is_active', true)]);

        if ($categorySlug !== '') {
            $productsQuery->where('category_id', $category?->id ?? 0);
        }

        $subcategorySlug = Str::slug((string) $request->query('subcategory', ''));
        if ($subcategorySlug !== '') {
            $productsQuery->whereHas('subcategory', fn (Builder $builder) => $builder
                ->where('status', true)->where('slug', $subcategorySlug)
                ->when($category, fn (Builder $subcategoryQuery) => $subcategoryQuery->where('category_id', $category->id)));
        }

        if ($query !== '') {
            $productsQuery->where(function (Builder $builder) use ($query): void {
                $like = '%'.addcslashes($query, '%_\\').'%';
                $builder->where('name', 'like', $like)
                    ->orWhere('brand', 'like', $like)
                    ->orWhere('sku', 'like', $like)
                    ->orWhere('short_description', 'like', $like)
                    ->orWhere('description', 'like', $like)
                    ->orWhereHas('category', fn (Builder $categoryQuery) => $categoryQuery->where('status', true)->where('name', 'like', $like))
                    ->orWhereHas('subcategory', fn (Builder $subQuery) => $subQuery->where('status', true)->where('name', 'like', $like));
            });
        }

        match ($sort) {
            'newest' => $productsQuery->latest(),
            'price_asc' => $productsQuery->orderByRaw('COALESCE(sale_price, price) ASC')->orderByDesc('id'),
            'price_desc' => $productsQuery->orderByRaw('COALESCE(sale_price, price) DESC')->orderByDesc('id'),
            default => $productsQuery->orderByDesc('is_featured')->latest(),
        };

        $products = $productsQuery->paginate(24)->withQueryString();
        $categories = Category::query()->where('status', true)->orderBy('sort_order')->orderBy('name')->get();

        return view('frontend.shop.index', compact('category', 'categorySlug', 'subcategorySlug', 'products', 'categories', 'query', 'sort'));
    }

    public function suggestions(Request $request): JsonResponse
    {
        $term = trim(Str::limit((string) $request->query('q', ''), 100, ''));
        if (mb_strlen($term) < 2) {
            return response()->json(['products' => [], 'categories' => []]);
        }

        $like = '%'.addcslashes($term, '%_\\').'%';
        $products = $this->availableProducts()
            ->where(fn (Builder $builder) => $builder->where('name', 'like', $like)
                ->orWhere('brand', 'like', $like)
                ->orWhere('sku', 'like', $like))
            ->with('category:id,name,slug')
            ->orderByDesc('is_featured')
            ->orderBy('name')
            ->limit(5)
            ->get(['id', 'name', 'slug', 'thumbnail', 'price', 'sale_price', 'category_id'])
            ->map(fn (Product $product) => [
                'name' => $product->name,
                'url' => route('shop.products.show', $product->slug),
                'image' => $product->thumbnail && is_file(public_path('uploads/products/'.$product->thumbnail))
                    ? asset('uploads/products/'.$product->thumbnail) : null,
                'price' => number_format((float) ($product->sale_price ?: $product->price), 2),
            ]);

        $categories = Category::query()->where('status', true)
            ->where('name', 'like', $like)
            ->orderBy('sort_order')->orderBy('name')->limit(4)
            ->get(['name', 'slug'])
            ->map(fn (Category $category) => ['name' => $category->name, 'url' => route('shop.index', ['category' => $category->slug])]);

        return response()->json(compact('products', 'categories'))
            ->header('Cache-Control', 'no-store, private');
    }

    private function availableProducts(): Builder
    {
        return Product::query()
            ->where('status', true)
            ->whereHas('category', fn (Builder $builder) => $builder->where('status', true))
            ->where(function (Builder $builder): void {
                $builder->where(function (Builder $standard): void {
                    $standard->whereDoesntHave('variants')
                        ->where(fn (Builder $stock) => $stock->where('stock', '>', 0)->orWhere('is_made_to_order', true));
                })->orWhere(function (Builder $variantProduct): void {
                    $variantProduct->whereHas('variants', fn (Builder $variants) => $variants->where('is_active', true))
                        ->where(fn (Builder $available) => $available->where('is_made_to_order', true)
                            ->orWhereHas('variants', fn (Builder $variants) => $variants->where('is_active', true)->where('stock', '>', 0)));
                });
            });
    }

    public function show(Product $product)
    {
        abort_unless($product->status && $product->category?->status, 404);
        $product->load(['category', 'images', 'variants' => fn ($query) => $query->where('is_active', true)->orderBy('size')->orderBy('color')]);
        $relatedProducts = $this->availableProducts()
            ->where('id', '!=', $product->id)
            ->where('category_id', $product->category_id)
            ->withCount(['variants' => fn ($query) => $query->where('is_active', true)])
            ->latest()->limit(4)->get();

        if ($relatedProducts->isEmpty()) {
            $relatedProducts = $this->availableProducts()
                ->where('id', '!=', $product->id)
                ->withCount(['variants' => fn ($query) => $query->where('is_active', true)])
                ->latest()->limit(4)->get();
        }

        return view('frontend.shop.show', compact('product', 'relatedProducts'));
    }
}
