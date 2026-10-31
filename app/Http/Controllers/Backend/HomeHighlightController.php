<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\HomeHighlight;
use Illuminate\Http\Request;

class HomeHighlightController extends Controller
{
    private const ICONS = [
        'craft' => 'Handcrafted',
        'community' => 'Artisan community',
        'leaf' => 'Sustainability',
        'shipping' => 'Delivery',
    ];

    public function index()
    {
        $highlights = HomeHighlight::query()->orderBy('sort_order')->orderBy('id')->paginate(12);

        return view('backend.home-highlight.index', compact('highlights'));
    }

    public function create()
    {
        $icons = self::ICONS;

        return view('backend.home-highlight.create', compact('icons'));
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;
        HomeHighlight::create($data);

        return redirect()->route('home-highlights.index')->with('success', 'Home page highlight added.');
    }

    public function edit(HomeHighlight $home_highlight)
    {
        $highlight = $home_highlight;
        $icons = self::ICONS;

        return view('backend.home-highlight.edit', compact('highlight', 'icons'));
    }

    public function update(Request $request, HomeHighlight $home_highlight)
    {
        $data = $this->validatedData($request);
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $home_highlight->update($data);

        return redirect()->route('home-highlights.index')->with('success', 'Home page highlight updated.');
    }

    public function destroy(HomeHighlight $home_highlight)
    {
        $home_highlight->delete();

        return redirect()->route('home-highlights.index')->with('success', 'Home page highlight removed.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'icon' => ['required', 'in:'.implode(',', array_keys(self::ICONS))],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
            'is_active' => ['required', 'boolean'],
        ]);
    }
}
