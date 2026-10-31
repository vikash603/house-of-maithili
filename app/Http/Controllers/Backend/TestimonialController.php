<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::query()->orderBy('sort_order')->orderByDesc('updated_at')->paginate(12);

        return view('backend.testimonial.index', compact('testimonials'));
    }

    public function create()
    {
        return view('backend.testimonial.create');
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data['photo'] = $this->storePhoto($request);
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;
        Testimonial::create($data);

        return redirect()->route('testimonials.index')->with('success', 'Testimonial saved.');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('backend.testimonial.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $data = $this->validatedData($request, $testimonial);
        $oldPhoto = $testimonial->photo;
        if ($request->hasFile('photo')) {
            $data['photo'] = $this->storePhoto($request);
        } else {
            unset($data['photo']);
        }
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $testimonial->update($data);

        if ($oldPhoto && isset($data['photo'])) {
            $this->deletePhoto($oldPhoto);
        }

        return redirect()->route('testimonials.index')->with('success', 'Testimonial updated.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $photo = $testimonial->photo;
        $testimonial->delete();
        $this->deletePhoto($photo);

        return redirect()->route('testimonials.index')->with('success', 'Testimonial deleted.');
    }

    private function validatedData(Request $request, ?Testimonial $testimonial = null): array
    {
        return $request->validate([
            'customer_name' => ['required', 'string', 'max:120'],
            'title' => ['nullable', 'string', 'max:160'],
            'quote' => ['required', 'string', 'max:1200'],
            'rating' => ['required', 'integer', 'between:1,5'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
            'is_active' => ['required', 'boolean'],
        ]);
    }

    private function storePhoto(Request $request): ?string
    {
        if (! $request->hasFile('photo')) {
            return null;
        }

        $directory = public_path('uploads/testimonials');
        File::ensureDirectoryExists($directory);
        $photo = $request->file('photo');
        $filename = Str::uuid().'.'.$photo->extension();
        $photo->move($directory, $filename);

        return 'uploads/testimonials/'.$filename;
    }

    private function deletePhoto(?string $path): void
    {
        if (! $path || ! Str::startsWith($path, 'uploads/testimonials/')) {
            return;
        }

        $file = public_path($path);
        if (File::exists($file)) {
            File::delete($file);
        }
    }
}
