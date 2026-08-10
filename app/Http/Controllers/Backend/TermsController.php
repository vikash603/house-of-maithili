<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Terms;

class TermsController extends Controller
{
    public function index()
    {
        $pages = Terms::latest()->get();
        return view('backend.terms.index', compact('pages'));
        
    }

    public function create(){
        return view('backend.terms.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'title' => 'required',
        'slug' => 'required|unique:terms,slug',
        'description' => 'required',
    ]);

    Terms::create([
        'title' => $request->title,
        'slug' => $request->slug ?? Str::slug($request->title),
        'description' => $request->description,
    ]);

    return redirect()->route('terms.index')
    ->with('success', 'Terms Created Successfully');
}

public function edit($id)
{
    $page = Terms::findOrFail($id);
    return view('backend.terms.edit', compact('page'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required',
        'slug' => 'required|unique:terms,slug,' . $id,
        'description' => 'required',
    ]);

    $page = Terms::findOrFail($id);

    $page->update([
        'title' => $request->title,
        'slug' => $request->slug,
        'description' => $request->description,
    ]);

    return redirect()->route('terms.index')
            ->with('success', 'Terms Updated Successfully');
}

 // DELETE
 public function destroy($id)
 {
     $page = Terms::findOrFail($id);
     $page->delete();

     return redirect()->back()
         ->with('success', 'Terms Deleted Successfully');
 }
}
