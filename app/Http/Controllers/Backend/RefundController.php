<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Refund;

class RefundController extends Controller
{
    public function index()
    {
        $pages = Refund::latest()->get();
        return view('backend.refund.index', compact('pages'));
        
    }

    public function create(){
        return view('backend.refund.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'title' => 'required',
        'slug' => 'required|unique:refund,slug',
        'description' => 'required',
    ]);

    Refund::create([
        'title' => $request->title,
        'slug' => $request->slug ?? Str::slug($request->title),
        'description' => $request->description,
    ]);

    return redirect()->route('refund.index')
    ->with('success', 'Refund Created Successfully');
}

public function edit($id)
{
    $page = Refund::findOrFail($id);
    return view('backend.refund.edit', compact('page'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required',
        'slug' => 'required|unique:refund,slug,' . $id,
        'description' => 'required',
    ]);

    $page = Refund::findOrFail($id);

    $page->update([
        'title' => $request->title,
        'slug' => $request->slug,
        'description' => $request->description,
    ]);

    return redirect()->route('refund.index')
            ->with('success', 'Refund Updated Successfully');
}

 // DELETE
 public function destroy($id)
 {
     $page = Refund::findOrFail($id);
     $page->delete();

     return redirect()->back()
         ->with('success', 'Refund Deleted Successfully');
 }
}
