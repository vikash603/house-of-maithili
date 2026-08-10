<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // ✅ LIST
    public function index(Request $request)
{
    $query = Product::with('category','subcategory');

    if ($request->search) {
        $query->where('name', 'like', '%'.$request->search.'%');
    }

    $products = $query->latest()->paginate(10);

    return view('backend.product.index', compact('products'));
}

    // ✅ CREATE PAGE
    public function create()
    {
        $categories = \App\Models\Category::where('status',1)->get();
        return view('backend.product.create', compact('categories'));
    }

    // ✅ STORE PRODUCT
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'name' => 'required',
            'price' => 'required|numeric',
            'thumbnail' => 'nullable|image'
        ]);

        // 🔥 THUMBNAIL
        $thumbName = null;

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $thumbName = time().'_thumb.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/products'), $thumbName);
        }

        // ✅ PRODUCT CREATE
        $product = Product::create([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'brand' => $request->brand,
            'sku' => uniqid(),
            'description' => $request->description,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'thumbnail' => $thumbName,
            'stock' => $request->stock ?? 0,
            'status' => 1
        ]);

        // 🔥 MULTIPLE IMAGES
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {

                $name = time().'_img.'.$img->getClientOriginalExtension();
                $img->move(public_path('uploads/products'), $name);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $name
                ]);
            }
        }

        // 🔥 VARIANTS
       // PRODUCT SAVE के बाद
if ($request->variants) {

    $sizes = $request->variants['size'];
    $colors = $request->variants['color'];
    $prices = $request->variants['price'];
    $stocks = $request->variants['stock'];

    foreach ($sizes as $key => $size) {

        if ($size || $colors[$key]) {

            \App\Models\ProductVariant::create([
                'product_id' => $product->id,
                'size' => $size,
                'color' => $colors[$key],
                'price' => $prices[$key] ?? 0,
                'stock' => $stocks[$key] ?? 0,
            ]);
        }
    }
}

        return redirect()->route('products.index')->with('success','Product Added Successfully');
    }


    // EDIT PAGE
public function edit($id)
{
    $product = Product::with('images','variants')->findOrFail($id);
    $categories = \App\Models\Category::all();

    return view('backend.product.edit', compact('product','categories'));
}


// UPDATE
public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);

    $request->validate([
        'name' => 'required',
        'price' => 'required|numeric'
    ]);

    // 🔥 Thumbnail update
    if ($request->hasFile('thumbnail')) {

        if ($product->thumbnail && file_exists(public_path('uploads/products/'.$product->thumbnail))) {
            unlink(public_path('uploads/products/'.$product->thumbnail));
        }

        $file = $request->file('thumbnail');
        $thumbName = time().'_thumb.'.$file->getClientOriginalExtension();
        $file->move(public_path('uploads/products'), $thumbName);

        $product->thumbnail = $thumbName;
    }

    // ✅ Update product
    $product->update([
        'category_id' => $request->category_id,
        'subcategory_id' => $request->subcategory_id,
        'name' => $request->name,
        'slug' => \Str::slug($request->name),
        'brand' => $request->brand,
        'description' => $request->description,
        'price' => $request->price,
        'sale_price' => $request->sale_price,
        'stock' => $request->stock,
        'status' => $request->status
    ]);

    // 🔥 ADD NEW IMAGES
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $img) {

            $name = time().'_img.'.$img->getClientOriginalExtension();
            $img->move(public_path('uploads/products'), $name);

            \App\Models\ProductImage::create([
                'product_id' => $product->id,
                'image' => $name
            ]);
        }
    }
    $product->variants()->delete();

    if ($request->variants) {

        foreach ($request->variants['size'] as $key => $size) {
    
            ProductVariant::create([
                'product_id' => $product->id,
                'size' => $size,
                'color' => $request->variants['color'][$key],
                'price' => $request->variants['price'][$key],
                'stock' => $request->variants['stock'][$key],
            ]);
        }
    }

    return redirect()->route('products.index')->with('success','Product Updated');
}

    // ✅ DELETE
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // delete thumbnail
        if ($product->thumbnail && file_exists(public_path('uploads/products/'.$product->thumbnail))) {
            unlink(public_path('uploads/products/'.$product->thumbnail));
        }

        // delete gallery
        foreach ($product->images as $img) {
            if (file_exists(public_path('uploads/products/'.$img->image))) {
                unlink(public_path('uploads/products/'.$img->image));
            }
        }

        $product->delete();

        return back()->with('success','Product Deleted');
    }

    public function deleteImage($id)
{
    $img = ProductImage::findOrFail($id);

    // file delete
    if ($img->image && file_exists(public_path('uploads/products/'.$img->image))) {
        unlink(public_path('uploads/products/'.$img->image));
    }

    $img->delete();

    return response()->json(['success' => true]);
}
}