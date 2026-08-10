<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\Category;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    public function index()
    {
        $subcategories = SubCategory::with('category')->latest()->paginate(10);
        $categories = Category::all();

        return view('backend.subcategory.index', compact('subcategories','categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'name' => 'required',
            'image' => 'nullable|image'
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'_sub.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/subcategory'), $imageName);
        }

        SubCategory::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'image' => $imageName,
            'status' => $request->status ?? 1
        ]);

        return back()->with('success','SubCategory Added');
    }

    public function update(Request $request, $id)
    {
        $sub = SubCategory::findOrFail($id);

        $request->validate([
            'category_id' => 'required',
            'name' => 'required'
        ]);

        $imageName = $sub->image;

        if ($request->hasFile('image')) {

            if ($sub->image && file_exists(public_path('uploads/subcategory/'.$sub->image))) {
                unlink(public_path('uploads/subcategory/'.$sub->image));
            }

            $image = $request->file('image');
            $imageName = time().'_sub.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/subcategory'), $imageName);
        }

        $sub->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'image' => $imageName,
            'status' => $request->status ?? 1
        ]);

        return back()->with('success','Updated Successfully');
    }

    public function destroy($id)
    {
        $sub = SubCategory::findOrFail($id);

        if ($sub->image && file_exists(public_path('uploads/subcategory/'.$sub->image))) {
            unlink(public_path('uploads/subcategory/'.$sub->image));
        }

        $sub->delete();

        return back()->with('success','Deleted Successfully');
    }
}