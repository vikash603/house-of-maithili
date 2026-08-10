<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\About;

class AboutController extends Controller
{
    public function index()
    {
        $pages = About::latest()->get();
        return view('backend.about.index', compact('pages'));
        
    }

    public function create(){
        return view('backend.about.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'title' => 'required',
        'slug' => 'required|unique:abouts,slug',
        'description' => 'required',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
    ]);

    $imageName = null;

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time().'.'.$image->getClientOriginalExtension();
        $image->move(public_path('uploads/about'), $imageName);
    }

    About::create([
        'title' => $request->title,
        'slug' => $request->slug,
        'description' => $request->description,
        'image' => $imageName
    ]);

    return redirect()->route('about.index')
    ->with('success', 'About Created Successfully');
}

public function edit($id)
{
    $page = About::findOrFail($id);
    return view('backend.about.edit', compact('page'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required',
        'slug' => 'required|unique:abouts,slug,' . $id,
        'description' => 'required',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
    ]);

    $page = About::findOrFail($id);

    $imageName = $page->image;

    if ($request->hasFile('image')) {

        // OLD IMAGE DELETE
        if ($page->image && File::exists(public_path('uploads/about/'.$page->image))) {
            File::delete(public_path('uploads/about/'.$page->image));
        }

        // NEW IMAGE UPLOAD
        $image = $request->file('image');
        $imageName = time().'.'.$image->getClientOriginalExtension();
        $image->move(public_path('uploads/about'), $imageName);
    }

    $page->update([
        'title' => $request->title,
        'slug' => $request->slug,
        'description' => $request->description,
        'image' => $imageName
    ]);

    return redirect()->route('about.index')
            ->with('success', 'About Updated Successfully');
}

 // DELETE
 public function destroy($id)
 {
     $page = About::findOrFail($id);
 
     if ($page->image && file_exists(public_path('uploads/about/'.$page->image))) {
         unlink(public_path('uploads/about/'.$page->image));
     }
 
     $page->delete();
 
     return redirect()->back()->with('success', 'Deleted successfully');
 }
}
