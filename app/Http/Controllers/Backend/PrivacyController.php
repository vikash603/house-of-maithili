<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Privacy;



class PrivacyController extends Controller
{
    public function index()
    {
        $pages = Privacy::latest()->get();
        return view('backend.privacy.index', compact('pages'));
        
    }

    public function create(){
        return view('backend.privacy.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'title' => 'required',
        'slug' => 'required|unique:privacy,slug',
        'description' => 'required',
    ]);

    Privacy::create([
        'title' => $request->title,
        'slug' => $request->slug ?? Str::slug($request->title),
        'description' => $request->description,
    ]);

    return redirect()->route('privacy.index')
    ->with('success', 'Privacy Created Successfully');
}

public function edit($id)
{
    $page = Privacy::findOrFail($id);
    return view('backend.privacy.edit', compact('page'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required',
        'slug' => 'required|unique:privacy,slug,' . $id,
        'description' => 'required',
    ]);

    $page = Privacy::findOrFail($id);

    $page->update([
        'title' => $request->title,
        'slug' => $request->slug,
        'description' => $request->description,
    ]);

    return redirect()->route('privacy.index')
            ->with('success', 'Privacy Updated Successfully');
}

 // DELETE
 public function destroy($id)
 {
     $page = Privacy::findOrFail($id);
     $page->delete();

     return redirect()->back()
         ->with('success', 'Privacy Deleted Successfully');
 }


}
