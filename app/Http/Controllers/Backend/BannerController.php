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
        $banners = Banner::query()->orderBy('placement')->orderBy('sort_order')->orderBy('id')->paginate(10);

        return view('backend.banner.index', compact('banners'));
    }

    public function create()
    {
        return view('backend.banner.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules(true));
        $stored = [];

        try {
            [$validated['image'], $validated['image_width'], $validated['image_height']] = $this->storeImage($request, 'image');
            $stored[] = $validated['image'];

            if ($request->hasFile('mobile_image')) {
                [$validated['mobile_image'], $validated['mobile_image_width'], $validated['mobile_image_height']] = $this->storeImage($request, 'mobile_image');
                $stored[] = $validated['mobile_image'];
            }

            $validated['sort_order'] = $validated['sort_order'] ?? 0;
            $validated['is_active'] = $request->boolean('is_active');
            Banner::create($validated);
        } catch (\Throwable $exception) {
            foreach ($stored as $path) {
                $this->deleteUploadedImage($path);
            }

            throw $exception;
        }

        return redirect()->route('banners.index')->with('success', 'Banner added successfully.');
    }

    public function edit(Banner $banner)
    {
        return view('backend.banner.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate($this->rules(false));
        $replaced = [];
        $stored = [];

        if ($request->boolean('remove_mobile_image') && ! $request->hasFile('mobile_image')) {
            if ($banner->mobile_image) {
                $replaced[] = $banner->mobile_image;
            }
            $validated['mobile_image'] = null;
            $validated['mobile_image_width'] = null;
            $validated['mobile_image_height'] = null;
        }
        unset($validated['remove_mobile_image']);

        try {
            foreach (['image', 'mobile_image'] as $field) {
                if (! $request->hasFile($field)) {
                    continue;
                }

                [$path, $width, $height] = $this->storeImage($request, $field);
                $stored[] = $path;
                $replaced[] = $banner->{$field};
                $validated[$field] = $path;
                $validated[$field.'_width'] = $width;
                $validated[$field.'_height'] = $height;
            }

            $validated['sort_order'] = $validated['sort_order'] ?? 0;
            $validated['is_active'] = $request->boolean('is_active');
            $banner->update($validated);
        } catch (\Throwable $exception) {
            foreach ($stored as $path) {
                $this->deleteUploadedImage($path);
            }

            throw $exception;
        }

        foreach ($replaced as $path) {
            if ($path) {
                $this->deleteIfUnused($path);
            }
        }

        return redirect()->route('banners.index')->with('success', 'Banner updated successfully.');
    }

    public function destroy(Banner $banner)
    {
        $images = array_filter([$banner->image, $banner->mobile_image]);
        $banner->delete();

        foreach ($images as $path) {
            $this->deleteIfUnused($path);
        }

        return redirect()->route('banners.index')->with('success', 'Banner deleted successfully.');
    }

    private function rules(bool $creating): array
    {
        return [
            'image' => [$creating ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'mobile_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'remove_mobile_image' => ['sometimes', 'boolean'],
            'placement' => ['required', 'string', 'in:'.implode(',', array_keys(Banner::PLACEMENTS))],
            'title' => ['nullable', 'string', 'max:160'],
            'subtitle' => ['nullable', 'string', 'max:2000'],
            'cta_text' => ['nullable', 'string', 'max:80'],
            'alt_text' => ['nullable', 'string', 'max:255'],
            'link_url' => ['nullable', 'string', 'max:2048', $this->linkUrlRule()],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
            'is_active' => ['required', 'boolean'],
        ];
    }

    /** @return array{string, int, int} */
    private function storeImage(Request $request, string $field): array
    {
        $directory = public_path('uploads/banners');
        File::ensureDirectoryExists($directory);

        $image = $request->file($field);
        $dimensions = @getimagesize($image->getPathname());
        if (! $dimensions || empty($dimensions[0]) || empty($dimensions[1])) {
            throw \Illuminate\Validation\ValidationException::withMessages([$field => 'The selected file is not a valid image.']);
        }

        $filename = Str::uuid().'.'.$image->extension();
        $image->move($directory, $filename);

        return ['uploads/banners/'.$filename, (int) $dimensions[0], (int) $dimensions[1]];
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

    private function deleteIfUnused(string $path): void
    {
        $stillReferenced = Banner::query()->where('image', $path)->orWhere('mobile_image', $path)->exists();
        if (! $stillReferenced) {
            $this->deleteUploadedImage($path);
        }
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
