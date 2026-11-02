<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Banner;
use App\Models\Story;
use App\Models\HomeHighlight;
use App\Models\Testimonial;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $testimonials = collect();
        $homeHighlights = collect();
        $banners = collect();
        $stories = collect();
        $heroBanners = collect();
        $signatureBanner = null;
        $makhanaBanner = null;
        $promotionalBanners = collect();
        $signatureSarees = collect();
        $makhanaProduct = null;
        $makhanaCategory = null;

        try {
            $banners = Banner::query()->where('is_active', true)
                ->orderBy('sort_order')->orderBy('id')->get();
            // Older banner rows may have a NULL/blank placement (or be read before
            // the placement migration is applied). Keep treating those legacy rows
            // as hero slides so the established header-area carousel never vanishes.
            $heroBanners = $banners->filter(fn (Banner $banner) =>
                in_array($banner->placement, ['hero', null, ''], true)
            )->values();
            $signatureBanner = $banners->firstWhere('placement', 'signature');
            $makhanaBanner = $banners->firstWhere('placement', 'makhana');
            $promotionalBanners = $banners->whereIn('placement', ['promotional', 'other'])->values();
        } catch (\Throwable $exception) {
            report($exception);
        }

        try {
            $stories = Story::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderByDesc('updated_at')
                ->get();
        } catch (\Throwable $exception) {
            report($exception);
        }

        try {
            $homeHighlights = HomeHighlight::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get();
        } catch (\Throwable $exception) {
            report($exception);
        }

        try {
            $testimonials = Testimonial::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderByDesc('updated_at')
                ->limit(12)
                ->get();
        } catch (\Throwable $exception) {
            report($exception);
        }

        try {
            $availableCategories = Category::query()
                ->where('status', 1)
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get();

            $availableSubcategories = SubCategory::query()->where('status', 1)
                ->whereHas('category', fn ($query) => $query->where('status', 1))
                ->with('category:id,name,slug')->orderBy('name')->get();

            $categoryDefinitions = [
                ['name' => 'Blouses', 'slug' => 'blouses', 'aliases' => ['blouse']],
                ['name' => 'Lehengas', 'slug' => 'lehengas', 'aliases' => ['lehenga', 'lehenga-choli']],
                ['name' => 'Dresses', 'slug' => 'dresses', 'aliases' => ['dress']],
                ['name' => 'Co-ord Sets', 'slug' => 'co-ord-sets', 'aliases' => ['co-ord-set', 'co-ords', 'co-ord']],
                ['name' => 'Sarees', 'slug' => 'sarees', 'aliases' => ['saree', 'saris', 'sari']],
                ['name' => 'Jackets', 'slug' => 'jackets', 'aliases' => ['jacket']],
                ['name' => 'Cushion Covers', 'slug' => 'cushion-covers', 'aliases' => ['cushion-cover']],
                ['name' => 'Bags', 'slug' => 'bags', 'aliases' => ['bag']],
            ];

            $matchedCategories = collect($categoryDefinitions)->map(function (array $definition) use ($availableCategories, $availableSubcategories) {
                $acceptedSlugs = array_merge([$definition['slug']], $definition['aliases']);
                $subcategory = null;
                foreach ($acceptedSlugs as $acceptedSlug) {
                    $subcategory = $availableSubcategories->first(fn (SubCategory $candidate) =>
                        \Illuminate\Support\Str::slug($candidate->slug ?: $candidate->name) === $acceptedSlug
                    );
                    if ($subcategory) break;
                }

                $category = $subcategory?->category;
                if (! $category) {
                    foreach ($acceptedSlugs as $acceptedSlug) {
                        $category = $availableCategories->first(fn (Category $candidate) =>
                            \Illuminate\Support\Str::slug($candidate->slug ?: $candidate->name) === $acceptedSlug
                        );
                        if ($category) break;
                    }
                }

                return ['definition' => $definition, 'category' => $category, 'subcategory' => $subcategory];
            });

            $subcategoryIds = $matchedCategories->pluck('subcategory')->filter()->pluck('id')->all();
            $categoryImageProducts = $subcategoryIds
                ? Product::query()->whereIn('subcategory_id', $subcategoryIds)->where('status', 1)
                    ->with('images')->orderByDesc('is_featured')->latest()->get(['id', 'category_id', 'subcategory_id', 'thumbnail'])
                    ->groupBy('subcategory_id')
                : collect();

            $shopCategories = $matchedCategories->map(function (array $match) use ($categoryImageProducts) {
                $definition = $match['definition'];
                $category = $match['category'];
                $subcategory = $match['subcategory'];
                $image = $subcategory?->image && is_file(public_path('uploads/subcategory/'.$subcategory->image))
                    ? asset('uploads/subcategory/'.$subcategory->image)
                    : ($category?->image && is_file(public_path('uploads/category/'.$category->image))
                        ? asset('uploads/category/'.$category->image)
                        : null);

                if (! $image && $subcategory) {
                    foreach ($categoryImageProducts->get($subcategory->id, collect()) as $product) {
                        $candidateImages = collect([$product->thumbnail])->merge($product->images->pluck('image'));
                        $validImage = $candidateImages->first(fn ($path) => $path && is_file(public_path('uploads/products/'.$path)));
                        if ($validImage) {
                            $image = asset('uploads/products/'.$validImage);
                            break;
                        }
                    }
                }

                if (! $image && $definition['name'] === 'Sarees') {
                    $campaignImage = 'frontend/images/Serene Saree Portrait in Heritage Architecture.png';
                    $image = is_file(public_path($campaignImage)) ? asset($campaignImage) : null;
                }

                return [
                    'name' => $definition['name'],
                    'slug' => $definition['slug'],
                    'category_slug' => $category?->slug,
                    'subcategory_slug' => $subcategory?->slug,
                    'image' => $image,
                    'category_exists' => (bool) $category,
                ];
            });

            $sareeSubcategory = $matchedCategories->first(fn (array $match) => $match['definition']['name'] === 'Sarees')['subcategory'] ?? null;
            $sareeCategory = $matchedCategories->first(fn (array $match) => $match['definition']['name'] === 'Sarees')['category'] ?? null;
            $signatureSarees = $sareeSubcategory && $sareeCategory ? Product::query()
                ->where('status', 1)
                ->where('category_id', $sareeCategory->id)
                ->where('subcategory_id', $sareeSubcategory->id)
                ->where(function ($query) {
                    $query->where(function ($standardProduct) {
                        $standardProduct->whereDoesntHave('variants')
                            ->where(fn ($availability) => $availability->where('stock', '>', 0)->orWhere('is_made_to_order', true));
                    })->orWhere(function ($variantProduct) {
                        $variantProduct->whereHas('variants', fn ($variants) => $variants->where('is_active', true))
                            ->where(fn ($availability) => $availability->where('is_made_to_order', true)
                                ->orWhereHas('variants', fn ($variants) => $variants->where('is_active', true)->where('stock', '>', 0)));
                    });
                })
                ->with(['category', 'images', 'variants' => fn ($query) => $query->where('is_active', true)->orderBy('id')])
                ->orderByDesc('is_featured')->latest()->limit(4)->get() : collect();

            $makhanaCategory = $availableCategories->first(fn (Category $category) =>
                str_contains(\Illuminate\Support\Str::slug($category->name.' '.$category->slug), 'makhana')
            );
            $makhanaProduct = Product::query()->where('status', 1)
                ->whereHas('category', fn ($query) => $query->where('status', 1))
                ->where(fn ($query) => $query->where('name', 'like', '%makhana%')->orWhereHas('category', fn ($categoryQuery) => $categoryQuery->where('slug', 'like', '%makhana%')))
                ->with(['category', 'images'])->orderByDesc('is_featured')->latest()->first();

            $bestsellers = Product::query()
                ->whereHas('category', function ($query) {
                    $query->where('status', 1);
                })
                ->where('status', 1)
                ->where(function ($query) {
                    $query->where(function ($standardProduct) {
                        $standardProduct->whereDoesntHave('variants')
                            ->where(fn ($availability) => $availability->where('stock', '>', 0)->orWhere('is_made_to_order', true));
                    })->orWhere(function ($variantProduct) {
                        $variantProduct->whereHas('variants', fn ($variants) => $variants->where('is_active', true))
                            ->where(function ($availability) {
                                $availability->where('is_made_to_order', true)
                                    ->orWhereHas('variants', fn ($variants) => $variants->where('is_active', true)->where('stock', '>', 0));
                            });
                    });
                })
                ->with(['category', 'images', 'variants' => fn ($query) => $query->where('is_active', true)->orderBy('id')])
                ->withCount(['variants' => fn ($query) => $query->where('is_active', true)])
                ->orderByDesc('is_featured')
                ->latest()
                ->limit(6)
                ->get();
        } catch (\Throwable $exception) {
            report($exception);
            $bestsellers = collect();
            $shopCategories = collect();
            $signatureSarees = collect();
            $makhanaProduct = null;
            $makhanaCategory = null;
        }

        return view('frontend.index', compact('bestsellers', 'shopCategories', 'signatureSarees', 'makhanaProduct', 'makhanaCategory', 'testimonials', 'homeHighlights', 'banners', 'heroBanners', 'signatureBanner', 'makhanaBanner', 'promotionalBanners', 'stories'));
    }
    
}
