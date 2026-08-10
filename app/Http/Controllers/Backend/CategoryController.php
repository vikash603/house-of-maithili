<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // ✅ LIST
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('backend.category.index', compact('categories'));
    }

    // ✅ STORE (ADD)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'_cat.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/category'), $imageName);
        }

       
        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'image' => $imageName,
            'status' => $request->status ?? 1
        ]);

        return back()->with('success','Category Added Successfully');
    }

    // ✅ EDIT (FORM LOAD)
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('backend.category.edit', compact('category'));
    }

    // ✅ UPDATE
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:categories,name,'.$id,
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $imageName = $category->image;

        // New image upload
        if ($request->hasFile('image')) {

            // Old image delete
            if ($category->image && file_exists(public_path('uploads/category/'.$category->image))) {
                unlink(public_path('uploads/category/'.$category->image));
            }

            $image = $request->file('image');
            $imageName = time().'_cat.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/category'), $imageName);
        }

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'image' => $imageName,
            'status' => $request->status ?? 1
        ]);

        return redirect()->route('categories.index')->with('success','Category Updated Successfully');
    }

    // ✅ DELETE
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Image delete
        if ($category->image && file_exists(public_path('uploads/category/'.$category->image))) {
            unlink(public_path('uploads/category/'.$category->image));
        }

        $category->delete();

        return back()->with('success', 'Category deleted successfully');
    }
}