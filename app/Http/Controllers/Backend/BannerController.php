<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(10);

        return view('backend.banner.index', compact('banners'));
    }

    public function create()
    {
        return view('backend.banner.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'alt_text' => ['nullable', 'string', 'max:255'],
            'link_url' => ['nullable', 'string', 'max:2048', $this->linkUrlRule()],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
            'is_active' => ['required', 'boolean'],
        ]);

        $validated['image'] = $this->storeImage($request);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active');

        Banner::create($validated);

        return redirect()->route('banners.index')->with('success', 'Banner added successfully.');
    }

    public function edit(Banner $banner)
    {
        return view('backend.banner.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'alt_text' => ['nullable', 'string', 'max:255'],
            'link_url' => ['nullable', 'string', 'max:2048', $this->linkUrlRule()],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
            'is_active' => ['required', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            $newImage = $this->storeImage($request);
            $oldImage = $banner->image;
            $validated['image'] = $newImage;
        }

        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active');
        $banner->update($validated);

        if (isset($oldImage)) {
            $this->deleteUploadedImage($oldImage);
        }

        return redirect()->route('banners.index')->with('success', 'Banner updated successfully.');
    }

    public function destroy(Banner $banner)
    {
        $image = $banner->image;
        $banner->delete();
        $this->deleteUploadedImage($image);

        return redirect()->route('banners.index')->with('success', 'Banner deleted successfully.');
    }

    private function storeImage(Request $request): string
    {
        $directory = public_path('uploads/banners');
        File::ensureDirectoryExists($directory);

        $image = $request->file('image');
        $filename = Str::uuid().'.'.$image->extension();
        $image->move($directory, $filename);

        return 'uploads/banners/'.$filename;
    }

    private function linkUrlRule(): \Closure
    {
        return function ($attribute, $value, $fail) {
            if ($value === null || $value === '') {
                return;
            }

            $isInternalPath = str_starts_with($value, '/')
                && ! str_starts_with($value, '//')
                && ! str_contains($value, '\\');
            $scheme = parse_url($value, PHP_URL_SCHEME);
            $isWebUrl = filter_var($value, FILTER_VALIDATE_URL)
                && in_array(strtolower((string) $scheme), ['http', 'https'], true);

            if (! $isInternalPath && ! $isWebUrl) {
                $fail('Enter a valid http/https URL or an internal path such as /shop.');
            }
        };
    }

    private function deleteUploadedImage(string $path): void
    {
        if (! Str::startsWith($path, 'uploads/banners/')) {
            return;
        }

        $filename = basename($path);
        $fullPath = public_path('uploads/banners/'.$filename);

        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }
    }
}
