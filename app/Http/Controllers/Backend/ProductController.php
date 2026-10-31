<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'subcategory'])
            ->withCount('variants')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = trim($request->string('search')->toString());
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', '%'.$search.'%')
                        ->orWhere('sku', 'like', '%'.$search.'%');
                });
            })
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->boolean('status')))
            ->when($request->filled('category_id'), fn ($query) => $query->where('category_id', $request->integer('category_id')));

        $products = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::where('status', 1)->orderBy('name')->get();

        return view('backend.product.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('status', 1)->orderBy('name')->get();
        $subcategories = collect();

        return view('backend.product.create', compact('categories', 'subcategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->productRules());
        $this->validateSubcategory($validated['category_id'], $validated['subcategory_id'] ?? null);
        $variants = $request->boolean('has_variants') ? $this->validatedVariants($validated['variants'] ?? [], $validated['price'], $validated['sale_price'] ?? null) : [];
        if ($request->boolean('has_variants') && $variants === []) throw ValidationException::withMessages(['variants' => 'Add at least one variant, or turn off size and colour options.']);

        $savedFiles = [];

        try {
            $product = DB::transaction(function () use ($request, $validated, $variants, &$savedFiles) {
                $productSku = $this->uniqueProductSku($validated['sku'] ?? null);
                $thumbnail = $request->hasFile('thumbnail') ? $this->storeImage($request->file('thumbnail')) : null;
                if ($thumbnail) $savedFiles[] = $thumbnail;

                $product = Product::create([
                    'category_id' => $validated['category_id'],
                    'subcategory_id' => $validated['subcategory_id'] ?? null,
                    'name' => $validated['name'],
                    'slug' => $this->uniqueSlug($validated['name']),
                    'brand' => $validated['brand'] ?? null,
                    'sku' => $productSku,
                    'short_description' => $validated['short_description'] ?? null,
                    'description' => $validated['description'] ?? null,
                    'price' => $validated['price'],
                    'sale_price' => $validated['sale_price'] ?? null,
                    'thumbnail' => $thumbnail,
                    'stock' => $variants ? collect($variants)->sum('stock') : ($validated['stock'] ?? 0),
                    'status' => $validated['status'],
                    'is_featured' => $request->boolean('is_featured'),
                    'is_trending' => $request->boolean('is_trending'),
                    'is_made_to_order' => $request->boolean('is_made_to_order'),
                    'lead_time_days' => $request->boolean('is_made_to_order') ? ($validated['lead_time_days'] ?? 15) : null,
                ]);

                $this->saveProductImages($request, $product, $savedFiles);
                $this->saveVariants($product, $variants);

                return $product;
            });
        } catch (\Throwable $exception) {
            $this->deleteFiles($savedFiles);
            throw $exception;
        }

        return redirect()->route('products.index')->with('success', "{$product->name} was created successfully.");
    }

    public function edit(Product $product)
    {
        $product->load(['images', 'variants']);
        $categories = Category::where('status', 1)->orderBy('name')->get();
        $subcategories = SubCategory::where('category_id', $product->category_id)->orderBy('name')->get();

        return view('backend.product.edit', compact('product', 'categories', 'subcategories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate($this->productRules($product));
        $this->validateSubcategory($validated['category_id'], $validated['subcategory_id'] ?? null);
        $variants = $request->boolean('has_variants') ? $this->validatedVariants($validated['variants'] ?? [], $validated['price'], $validated['sale_price'] ?? null, $product) : [];
        if ($request->boolean('has_variants') && $variants === []) throw ValidationException::withMessages(['variants' => 'Add at least one variant, or turn off size and colour options.']);

        $savedFiles = [];
        $oldFiles = [];

        try {
            DB::transaction(function () use ($request, $product, $validated, $variants, &$savedFiles, &$oldFiles) {
                $product->refresh();
                $thumbnail = $product->thumbnail;
                if ($request->hasFile('thumbnail')) {
                    $oldFiles[] = $product->thumbnail;
                    $thumbnail = $this->storeImage($request->file('thumbnail'));
                    $savedFiles[] = $thumbnail;
                }

                $product->update([
                    'category_id' => $validated['category_id'],
                    'subcategory_id' => $validated['subcategory_id'] ?? null,
                    'name' => $validated['name'],
                    'slug' => $this->uniqueSlug($validated['name'], $product),
                    'brand' => $validated['brand'] ?? null,
                    'sku' => $this->uniqueProductSku($validated['sku'] ?? $product->sku, $product),
                    'short_description' => $validated['short_description'] ?? null,
                    'description' => $validated['description'] ?? null,
                    'price' => $validated['price'],
                    'sale_price' => $validated['sale_price'] ?? null,
                    'thumbnail' => $thumbnail,
                    'stock' => $variants ? collect($variants)->sum('stock') : ($validated['stock'] ?? 0),
                    'status' => $validated['status'],
                    'is_featured' => $request->boolean('is_featured'),
                    'is_trending' => $request->boolean('is_trending'),
                    'is_made_to_order' => $request->boolean('is_made_to_order'),
                    'lead_time_days' => $request->boolean('is_made_to_order') ? ($validated['lead_time_days'] ?? 15) : null,
                ]);

                $this->saveProductImages($request, $product, $savedFiles);
                $oldFiles = array_merge($oldFiles, $this->syncVariants($product, $variants));
            });
        } catch (\Throwable $exception) {
            $this->deleteFiles($savedFiles);
            throw $exception;
        }

        $this->deleteFiles($oldFiles);

        return redirect()->route('products.index')->with('success', "{$product->name} was updated successfully.");
    }

    public function destroy(Product $product)
    {
        $product->load(['images', 'variants']);
        $files = collect([$product->thumbnail])
            ->merge($product->images->pluck('image'))
            ->filter()
            ->all();

        $product->delete();
        $this->deleteFiles($files);

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    public function deleteImage($id)
    {
        $image = ProductImage::findOrFail($id);
        $path = $image->image;
        $image->delete();
        $this->deleteFiles([$path]);

        return response()->json(['success' => true]);
    }

    private function productRules(?Product $product = null): array
    {
        return [
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'subcategory_id' => ['nullable', 'integer', 'exists:sub_categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['nullable', 'string', 'max:100', Rule::unique('products', 'sku')->ignore($product?->id)],
            'brand' => ['nullable', 'string', 'max:120'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string', 'max:20000'],
            'price' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'sale_price' => ['nullable', 'numeric', 'min:0', 'lte:price'],
            'stock' => ['nullable', 'integer', 'min:0', 'max:10000000'],
            'status' => ['required', 'boolean'],
            'has_variants' => ['nullable', 'boolean'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'images' => ['nullable', 'array', 'max:12'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'is_featured' => ['nullable', 'boolean'],
            'is_trending' => ['nullable', 'boolean'],
            'is_made_to_order' => ['nullable', 'boolean'],
            'lead_time_days' => ['nullable', 'integer', 'min:1', 'max:120'],
            'variants' => ['nullable', 'array', 'max:100'],
            'variants.*.size' => ['nullable', 'string', 'max:50'],
            'variants.*.color' => ['nullable', 'string', 'max:60'],
            'variants.*.sku' => ['nullable', 'string', 'max:100', 'distinct'],
            'variants.*.price' => ['nullable', 'numeric', 'min:0', 'max:99999999.99'],
            'variants.*.sale_price' => ['nullable', 'numeric', 'min:0'],
            'variants.*.stock' => ['required_with:variants', 'integer', 'min:0', 'max:10000000'],
            'variants.*.is_active' => ['nullable', 'boolean'],
        ];
    }

    private function validateSubcategory(int $categoryId, ?int $subcategoryId): void
    {
        if ($subcategoryId && ! SubCategory::whereKey($subcategoryId)->where('category_id', $categoryId)->exists()) {
            throw ValidationException::withMessages(['subcategory_id' => 'Choose a subcategory that belongs to the selected category.']);
        }
    }

    private function validatedVariants(array $rows, string|float|int $basePrice, string|float|int|null $baseSalePrice, ?Product $product = null): array
    {
        $variants = [];
        $seen = [];

        foreach ($rows as $index => $row) {
            $size = trim((string) ($row['size'] ?? ''));
            $color = trim((string) ($row['color'] ?? ''));

            if ($size === '' && $color === '') {
                throw ValidationException::withMessages(["variants.{$index}.size" => 'Each variant needs a size, a color, or both.']);
            }

            $sku = trim((string) ($row['sku'] ?? ''));
            $price = $row['price'] !== '' && $row['price'] !== null ? $row['price'] : $basePrice;
            $salePrice = ($row['sale_price'] ?? '') !== '' ? $row['sale_price'] : $baseSalePrice;

            if ($salePrice !== null && (float) $salePrice > (float) $price) {
                throw ValidationException::withMessages(["variants.{$index}.sale_price" => 'Variant sale price cannot be higher than its price.']);
            }

            if ($sku === '') {
                $sku = $this->generatedVariantSku($product?->sku, $size, $color, $index);
            }

            $normalizedSku = Str::lower($sku);
            if (isset($seen[$normalizedSku])) {
                throw ValidationException::withMessages(["variants.{$index}.sku" => 'Variant SKUs must be unique within this product.']);
            }
            $seen[$normalizedSku] = true;

            $existing = ProductVariant::where('sku', $sku)
                ->when($product, fn ($query) => $query->where('product_id', '!=', $product->id))
                ->exists();
            if ($existing) {
                throw ValidationException::withMessages(["variants.{$index}.sku" => "Variant SKU '{$sku}' is already in use."]);
            }

            $variants[] = [
                'size' => $size ?: null,
                'color' => $color ?: null,
                'sku' => $sku,
                'price' => $price,
                'sale_price' => $salePrice,
                'stock' => (int) ($row['stock'] ?? 0),
                'is_active' => filter_var($row['is_active'] ?? true, FILTER_VALIDATE_BOOLEAN),
            ];
        }

        return $variants;
    }

    private function saveVariants(Product $product, array $variants): void
    {
        foreach ($variants as $variant) {
            $product->variants()->create($variant);
        }
    }

    private function syncVariants(Product $product, array $variants): array
    {
        $product->variants()->delete();
        $this->saveVariants($product, $variants);

        return [];
    }

    private function saveProductImages(Request $request, Product $product, array &$savedFiles): void
    {
        foreach ($request->file('images', []) as $image) {
            $filename = $this->storeImage($image);
            $savedFiles[] = $filename;
            $product->images()->create(['image' => $filename]);
        }
    }

    private function storeImage(\Illuminate\Http\UploadedFile $image): string
    {
        $directory = public_path('uploads/products');
        File::ensureDirectoryExists($directory);
        $filename = Str::uuid().'.'.$image->extension();
        $image->move($directory, $filename);

        return $filename;
    }

    private function deleteFiles(array $files): void
    {
        foreach (array_filter($files) as $filename) {
            $path = public_path('uploads/products/'.basename($filename));
            if (File::exists($path)) File::delete($path);
        }
    }

    private function uniqueProductSku(?string $requestedSku, ?Product $product = null): string
    {
        $sku = trim((string) $requestedSku);
        if ($sku === '') {
            do {
                $sku = 'HOM-P-'.Str::upper(Str::random(10));
            } while (Product::where('sku', $sku)->when($product, fn ($query) => $query->where('id', '!=', $product->id))->exists());
        }

        return $sku;
    }

    private function uniqueSlug(string $name, ?Product $product = null): string
    {
        $base = Str::slug($name) ?: 'product';
        $slug = $base;
        $suffix = 2;

        while (Product::where('slug', $slug)->when($product, fn ($query) => $query->where('id', '!=', $product->id))->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }

    private function generatedVariantSku(?string $productSku, string $size, string $color, int $index): string
    {
        $parts = array_filter([$productSku ?: 'HOM', Str::slug($size), Str::slug($color)]);
        $base = Str::upper(implode('-', $parts));
        $sku = $base;
        $suffix = $index + 1;

        while (ProductVariant::where('sku', $sku)->exists()) {
            $sku = $base.'-'.$suffix++;
        }

        return $sku;
    }
}
