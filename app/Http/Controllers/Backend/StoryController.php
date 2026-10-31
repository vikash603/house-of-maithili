<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class StoryController extends Controller
{
    public function index()
    {
        $stories = Story::query()->orderBy('sort_order')->orderByDesc('updated_at')->paginate(12);

        return view('backend.story.index', compact('stories'));
    }

    public function create()
    {
        return view('backend.story.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateStory($request);
        $this->storeMedia($request, $validated);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        Story::create($validated);

        return redirect()->route('stories.index')->with('success', 'Story added successfully.');
    }

    public function edit(Story $story)
    {
        return view('backend.story.edit', compact('story'));
    }

    public function update(Request $request, Story $story)
    {
        $validated = $this->validateStory($request, $story);
        $oldThumbnail = $story->thumbnail;
        $oldVideo = $story->video_file;

        $this->storeMedia($request, $validated);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        if ($validated['video_type'] === 'youtube') {
            $validated['video_file'] = null;
        } else {
            $validated['youtube_url'] = null;
        }

        $story->update($validated);

        if (($validated['thumbnail'] ?? null) && $oldThumbnail) {
            $this->deleteMedia($oldThumbnail, 'uploads/story-thumbnails/');
        }
        if ($oldVideo && (! empty($validated['video_file']) || $validated['video_type'] !== 'local')) {
            $this->deleteMedia($oldVideo, 'uploads/story-videos/');
        }

        return redirect()->route('stories.index')->with('success', 'Story updated successfully.');
    }

    public function destroy(Story $story)
    {
        $thumbnail = $story->thumbnail;
        $video = $story->video_file;
        $story->delete();
        $this->deleteMedia($thumbnail, 'uploads/story-thumbnails/');
        $this->deleteMedia($video, 'uploads/story-videos/');

        return redirect()->route('stories.index')->with('success', 'Story deleted successfully.');
    }

    private function validateStory(Request $request, ?Story $story = null): array
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:140'],
            'description' => ['nullable', 'string', 'max:500'],
            'video_type' => ['required', 'in:local,youtube'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'video_file' => ['nullable', 'file', 'mimes:mp4,webm,mov', 'max:102400'],
            'youtube_url' => ['nullable', 'string', 'max:512', 'required_if:video_type,youtube'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
            'is_active' => ['required', 'boolean'],
        ], [
            'youtube_url.required_if' => 'Enter a YouTube video URL.',
            'video_file.max' => 'The video must be 100 MB or smaller.',
        ]);

        $validator->after(function ($validator) use ($request, $story) {
            if ($request->input('video_type') === 'youtube' && $request->filled('youtube_url') && ! $this->youtubeVideoId($request->input('youtube_url'))) {
                $validator->errors()->add('youtube_url', 'Enter a valid YouTube video URL (youtube.com or youtu.be).');
            }
            if ($request->input('video_type') === 'local') {
                if (! $request->hasFile('thumbnail') && ! $story?->thumbnail) {
                    $validator->errors()->add('thumbnail', 'Upload a thumbnail image for this story.');
                }
                if (! $request->hasFile('video_file') && ! ($story?->video_type === 'local' && $story->video_file)) {
                    $validator->errors()->add('video_file', 'Upload a video file for the local video option.');
                }
            }
        });

        return $validator->validate();
    }

    private function youtubeVideoId(?string $url): ?string
    {
        if (! $url || ! filter_var($url, FILTER_VALIDATE_URL)) {
            return null;
        }

        $parts = parse_url($url);
        $host = strtolower($parts['host'] ?? '');
        if (! in_array($host, ['youtube.com', 'www.youtube.com', 'm.youtube.com', 'youtu.be', 'www.youtu.be'], true)) {
            return null;
        }

        $path = trim($parts['path'] ?? '', '/');
        $id = null;
        if (str_contains($host, 'youtu.be')) {
            $id = explode('/', $path)[0] ?? null;
        } elseif (str_starts_with($path, 'watch')) {
            parse_str($parts['query'] ?? '', $query);
            $id = $query['v'] ?? null;
        } elseif (preg_match('~^(?:embed|shorts|live)/([^/]+)~', $path, $matches)) {
            $id = $matches[1];
        }

        return is_string($id) && preg_match('/^[A-Za-z0-9_-]{11}$/', $id) ? $id : null;
    }

    private function storeMedia(Request $request, array &$validated): void
    {
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $this->storeUpload($request->file('thumbnail'), 'story-thumbnails');
        }
        if ($request->hasFile('video_file')) {
            $validated['video_file'] = $this->storeUpload($request->file('video_file'), 'story-videos');
        }
    }

    private function storeUpload($file, string $directory): string
    {
        $target = public_path('uploads/'.$directory);
        File::ensureDirectoryExists($target);
        $filename = Str::uuid().'.'.$file->extension();
        $file->move($target, $filename);

        return 'uploads/'.$directory.'/'.$filename;
    }

    private function deleteMedia(?string $path, string $allowedPrefix): void
    {
        if (! $path || ! Str::startsWith($path, $allowedPrefix)) {
            return;
        }

        $file = public_path($path);
        if (File::exists($file)) {
            File::delete($file);
        }
    }
}
