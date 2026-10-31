<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use ZipArchive;

class BulkProductImportController extends Controller
{
    private const HEADERS = ['product_sku','name','category','subcategory','brand','short_description','description','price','sale_price','stock','status','is_made_to_order','lead_time_days','thumbnail','images','variant_sku','size','color','variant_price','variant_sale_price','variant_stock','variant_active'];

    public function index()
    {
        return view('backend.product.import');
    }

    public function template()
    {
        $example = ['HOM-LEH-001','Black Hand Painted Lehenga','Women','Lehengas','House Of Maithili','Hand painted Madhubani lehenga','Handcrafted in Purnea, Bihar','6500','5999','0','1','1','15','lehenga-cover.jpg','lehenga-cover.jpg|lehenga-back.jpg','HOM-LEH-001-M-BLK','M','Black','6500','5999','2','1'];
        return response()->streamDownload(function () use ($example) {
            $out = fopen('php://output', 'w');
            fputcsv($out, self::HEADERS);
            fputcsv($out, $example);
            fclose($out);
        }, 'house-of-maithili-product-import-template.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function preview(Request $request)
    {
        $request->validate([
            'csv' => ['required','file','mimes:csv,txt','max:10240'],
            'images_zip' => ['nullable','file','mimes:zip','max:51200'],
        ]);

        $id = (string) Str::uuid();
        $directory = storage_path('app/private/product-imports/'.$id);
        File::ensureDirectoryExists($directory);
        $request->file('csv')->move($directory, 'products.csv');
        if ($request->hasFile('images_zip')) $request->file('images_zip')->move($directory, 'images.zip');

        try {
            [$products, $errors] = $this->parseCsv($directory.'/products.csv');
            if (count($products) > 200) $errors[] = 'A single import can contain up to 200 products.';
            if (is_file($directory.'/images.zip')) {
                $zip = new ZipArchive();
                if ($zip->open($directory.'/images.zip') !== true) $errors[] = 'The image ZIP could not be opened.';
                else {
                    if ($zip->numFiles > 1000) $errors[] = 'The ZIP can contain up to 1,000 image files.';
                    $availableImages = [];
                    for ($i = 0; $i < $zip->numFiles; $i++) {
                        $entry = basename(str_replace('\\', '/', (string) $zip->getNameIndex($i)));
                        if ($entry !== '' && preg_match('/\.(jpe?g|png|webp)$/i', $entry)) $availableImages[strtolower($entry)] = true;
                    }
                    $zip->close();
                    foreach ($products as $product) {
                        foreach (array_filter(array_merge([$product['thumbnail']], $product['images'])) as $filename) {
                            if (!isset($availableImages[strtolower(basename(str_replace('\\', '/', $filename)))])) $errors[] = "Row {$product['row']}: image '{$filename}' was not found in the ZIP.";
                        }
                    }
                }
            } else {
                foreach ($products as $product) {
                    if ($product['thumbnail'] || array_filter($product['images'])) $errors[] = "Row {$product['row']}: upload an images ZIP because this product references images.";
                }
            }
            $errors = array_merge($errors, $this->validateProducts($products));
            if ($errors) {
                File::deleteDirectory($directory);
                return back()->withInput()->with('import_errors', array_slice($errors, 0, 100));
            }
            File::put($directory.'/validated.json', json_encode($products, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR));
            session(['product_import_id' => $id]);
            return view('backend.product.import-preview', ['products' => $products]);
        } catch (\Throwable $e) {
            File::deleteDirectory($directory);
            throw $e;
        }
    }

    public function confirm(Request $request)
    {
        $id = session('product_import_id');
        abort_unless(is_string($id) && preg_match('/^[a-f0-9-]{36}$/', $id), 419);
        $directory = storage_path('app/private/product-imports/'.$id);
        $json = $directory.'/validated.json';
        abort_unless(is_file($json), 419);
        $products = json_decode(File::get($json), true, 512, JSON_THROW_ON_ERROR);
        $imageMap = $this->extractImages($directory);
        $savedFiles = [];

        try {
            DB::transaction(function () use ($products, $imageMap, &$savedFiles) {
                foreach ($products as $data) {
                    $sku = $data['sku'] ?: 'HOM-P-'.Str::upper(Str::random(10));
                    if (Product::where('sku', $sku)->exists()) throw ValidationException::withMessages(['csv' => "Product SKU {$sku} was added after preview. Please preview the file again."]);
                    $thumbnail = $this->copyImportImage($data['thumbnail'] ?? '', $imageMap, $savedFiles);
                    $slugBase = Str::slug($data['name']) ?: 'product'; $slug = $slugBase; $n = 2;
                    while (Product::where('slug', $slug)->exists()) $slug = $slugBase.'-'.$n++;
                    $product = Product::create([
                        'category_id'=>$data['category_id'], 'subcategory_id'=>$data['subcategory_id'], 'name'=>$data['name'], 'slug'=>$slug,
                        'brand'=>$data['brand'], 'sku'=>$sku, 'short_description'=>$data['short_description'], 'description'=>$data['description'],
                        'price'=>$data['price'], 'sale_price'=>$data['sale_price'], 'thumbnail'=>$thumbnail,
                        'stock'=>count($data['variants']) ? collect($data['variants'])->sum('stock') : $data['stock'], 'status'=>$data['status'],
                        'is_made_to_order'=>$data['is_made_to_order'], 'lead_time_days'=>$data['is_made_to_order'] ? $data['lead_time_days'] : null,
                    ]);
                    foreach (array_unique(array_filter($data['images'])) as $image) {
                        if ($image === ($data['thumbnail'] ?? '')) continue;
                        $filename = $this->copyImportImage($image, $imageMap, $savedFiles);
                        if ($filename) $product->images()->create(['image'=>$filename]);
                    }
                    foreach ($data['variants'] as $variant) {
                        $variant['sku'] = $variant['sku'] ?: Str::upper($sku.'-'.Str::random(5));
                        $product->variants()->create($variant);
                    }
                }
            });
        } catch (\Throwable $e) {
            foreach ($savedFiles as $filename) @unlink(public_path('uploads/products/'.$filename));
            throw $e;
        } finally {
            File::deleteDirectory($directory);
            session()->forget('product_import_id');
        }

        return redirect()->route('products.index')->with('success', count($products).' products imported successfully.');
    }

    public function cancel()
    {
        $id = session('product_import_id');
        if (is_string($id) && preg_match('/^[a-f0-9-]{36}$/', $id)) File::deleteDirectory(storage_path('app/private/product-imports/'.$id));
        session()->forget('product_import_id');
        return redirect()->route('products.import')->with('success', 'Import cancelled. No products were added.');
    }

    private function parseCsv(string $path): array
    {
        $handle = fopen($path, 'r');
        if (!$handle) throw ValidationException::withMessages(['csv'=>'Could not read the CSV file.']);
        $headers = fgetcsv($handle);
        if (!$headers) { fclose($handle); return [[], ['The CSV file is empty.']]; }
        $headers[0] = preg_replace('/^\xEF\xBB\xBF/', '', (string) $headers[0]);
        $headers = array_map(fn($v) => strtolower(trim((string)$v)), $headers);
        $missing = array_diff(self::HEADERS, $headers);
        if ($missing) { fclose($handle); return [[], ['Missing CSV columns: '.implode(', ', $missing)]]; }
        $products = []; $errors = []; $rowNumber = 1;
        while (($values = fgetcsv($handle)) !== false) {
            $rowNumber++;
            if (count(array_filter($values, fn($v) => trim((string)$v) !== '')) === 0) continue;
            if ($rowNumber > 2001) { $errors[] = 'CSV contains more than 2,000 rows.'; break; }
            $row = array_combine($headers, array_pad(array_slice($values, 0, count($headers)), count($headers), ''));
            $key = trim($row['product_sku']) ?: 'row-'.$rowNumber;
            if (!isset($products[$key])) {
                $products[$key] = [
                    'sku'=>trim($row['product_sku']), 'name'=>trim($row['name']), 'category'=>trim($row['category']), 'subcategory'=>trim($row['subcategory']),
                    'brand'=>trim($row['brand']) ?: null, 'short_description'=>trim($row['short_description']) ?: null, 'description'=>trim($row['description']) ?: null,
                    'price'=>$row['price'], 'sale_price'=>$row['sale_price'] !== '' ? $row['sale_price'] : null, 'stock'=>(int)$row['stock'],
                    'status'=>$this->boolValue($row['status'], 1), 'is_made_to_order'=>$this->boolValue($row['is_made_to_order'], 0), 'lead_time_days'=>(int)($row['lead_time_days'] ?: 15),
                    'thumbnail'=>trim($row['thumbnail']), 'images'=>array_filter(array_map('trim', explode('|', $row['images']))), 'variants'=>[], 'row'=>$rowNumber,
                ];
            } elseif (trim($row['name']) && trim($row['name']) !== $products[$key]['name']) $errors[] = "Row {$rowNumber}: product details must match other rows with SKU {$key}.";
            if (trim($row['variant_sku']) || trim($row['size']) || trim($row['color'])) {
                $products[$key]['variants'][] = ['sku'=>trim($row['variant_sku']) ?: null,'size'=>trim($row['size']) ?: null,'color'=>trim($row['color']) ?: null,
                    'price'=>$row['variant_price'] !== '' ? $row['variant_price'] : $row['price'], 'sale_price'=>$row['variant_sale_price'] !== '' ? $row['variant_sale_price'] : ($row['sale_price'] ?: null),
                    'stock'=>(int)$row['variant_stock'], 'is_active'=>$this->boolValue($row['variant_active'], 1)];
            }
        }
        fclose($handle);
        return [array_values($products), $errors];
    }

    private function validateProducts(array &$products): array
    {
        $errors = []; $seenProduct = []; $seenVariant = [];
        foreach ($products as &$product) {
            $row = $product['row'];
            $seenOptions = [];
            if (!$product['name']) $errors[] = "Row {$row}: product name is required.";
            if (!is_numeric($product['price']) || $product['price'] < 0) $errors[] = "Row {$row}: enter a valid product price.";
            if ($product['sale_price'] !== null && (!is_numeric($product['sale_price']) || $product['sale_price'] > $product['price'])) $errors[] = "Row {$row}: sale price must be no higher than product price.";
            $category = Category::where('name', $product['category'])->orWhere('slug', $product['category'])->first();
            if (!$category) $errors[] = "Row {$row}: category '{$product['category']}' was not found.";
            else $product['category_id'] = $category->id;
            $subcategory = null;
            if ($product['subcategory']) $subcategory = SubCategory::where('name', $product['subcategory'])->orWhere('slug', $product['subcategory'])->first();
            if ($product['subcategory'] && (!$subcategory || ($category && $subcategory->category_id !== $category->id))) $errors[] = "Row {$row}: subcategory '{$product['subcategory']}' does not belong to its category.";
            $product['subcategory_id'] = $subcategory?->id;
            if ($product['sku']) {
                $key = strtolower($product['sku']);
                if (isset($seenProduct[$key]) || Product::where('sku', $product['sku'])->exists()) $errors[] = "Row {$row}: product SKU '{$product['sku']}' already exists in this file or catalog.";
                $seenProduct[$key] = true;
            }
            if ($product['is_made_to_order'] && ($product['lead_time_days'] < 1 || $product['lead_time_days'] > 120)) $errors[] = "Row {$row}: made-to-order lead time must be 1–120 days.";
            if ($product['variants']) $product['stock'] = array_sum(array_column($product['variants'], 'stock'));
            foreach ($product['variants'] as $variant) {
                $optionKey = strtolower((string) $variant['size']).'|'.strtolower((string) $variant['color']);
                if (isset($seenOptions[$optionKey])) $errors[] = "Row {$row}: duplicate size/colour combination for product '{$product['name']}'.";
                $seenOptions[$optionKey] = true;
                if (!$variant['size'] && !$variant['color']) $errors[] = "Row {$row}: each variant needs a size, colour, or both.";
                if ($variant['sku']) {
                    $key = strtolower($variant['sku']);
                    if (isset($seenVariant[$key]) || ProductVariant::where('sku', $variant['sku'])->exists()) $errors[] = "Row {$row}: variant SKU '{$variant['sku']}' already exists.";
                    $seenVariant[$key] = true;
                }
                if (!is_numeric($variant['price']) || $variant['price'] < 0 || ($variant['sale_price'] !== null && (!is_numeric($variant['sale_price']) || $variant['sale_price'] > $variant['price']))) $errors[] = "Row {$row}: invalid variant price or sale price.";
                if ($variant['stock'] < 0) $errors[] = "Row {$row}: variant stock cannot be negative.";
            }
        }
        unset($product);
        return $errors;
    }

    private function extractImages(string $directory): array
    {
        if (!is_file($directory.'/images.zip')) return [];
        $zip = new ZipArchive(); if ($zip->open($directory.'/images.zip') !== true) return [];
        $map = []; $total = 0;
        for ($i=0; $i<$zip->numFiles; $i++) {
            $name = $zip->getNameIndex($i); $base = basename(str_replace('\\', '/', (string)$name));
            if (!$base || $base === '.' || $base === '..' || !preg_match('/\.(jpe?g|png|webp)$/i', $base)) continue;
            $stream = $zip->getStream($name); if (!$stream) continue;
            $contents = stream_get_contents($stream); fclose($stream); $total += strlen($contents);
            if ($total > 100 * 1024 * 1024) { $zip->close(); throw ValidationException::withMessages(['images_zip'=>'Images ZIP must be under 100 MB uncompressed.']); }
            $map[$base] = $contents;
        }
        $zip->close(); return $map;
    }

    private function copyImportImage(string $name, array $imageMap, array &$saved): ?string
    {
        if ($name === '') return null;
        $base = basename(str_replace('\\', '/', $name));
        if (!isset($imageMap[$base])) throw ValidationException::withMessages(['images_zip'=>"Image '{$base}' is referenced by CSV but missing from the uploaded ZIP."]);
        $image = @getimagesizefromstring($imageMap[$base]);
        if (!$image || !in_array($image['mime'], ['image/jpeg','image/png','image/webp'], true)) throw ValidationException::withMessages(['images_zip'=>"Image '{$base}' is not a valid JPG, PNG or WebP image."]);
        File::ensureDirectoryExists(public_path('uploads/products'));
        $extension = ['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'][$image['mime']];
        $filename = Str::uuid().'.'.$extension;
        File::put(public_path('uploads/products/'.$filename), $imageMap[$base]); $saved[] = $filename;
        return $filename;
    }

    private function boolValue(string $value, int $default): int
    {
        $value = strtolower(trim($value));
        if ($value === '') return $default;
        return in_array($value, ['1','true','yes','active','enabled'], true) ? 1 : 0;
    }
}
