<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    protected $fillable = [
        'title',
        'description',
        'thumbnail',
        'video_type',
        'youtube_url',
        'video_file',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function youtubeVideoId(): ?string
    {
        if ($this->video_type !== 'youtube' || ! $this->youtube_url) {
            return null;
        }

        $url = parse_url($this->youtube_url);
        $host = strtolower($url['host'] ?? '');
        $path = trim($url['path'] ?? '', '/');
        $id = null;

        if (in_array($host, ['youtu.be', 'www.youtu.be'], true)) {
            $id = explode('/', $path)[0] ?? null;
        } elseif (in_array($host, ['youtube.com', 'www.youtube.com', 'm.youtube.com', 'youtube-nocookie.com', 'www.youtube-nocookie.com'], true)) {
            if (str_starts_with($path, 'watch')) {
                parse_str($url['query'] ?? '', $query);
                $id = $query['v'] ?? null;
            } elseif (preg_match('~^(?:embed|shorts|live)/([^/]+)~', $path, $matches)) {
                $id = $matches[1];
            }
        }

        return is_string($id) && preg_match('/^[A-Za-z0-9_-]{11}$/', $id) ? $id : null;
    }

    public function youtubeEmbedUrl(): ?string
    {
        $id = $this->youtubeVideoId();

        return $id ? 'https://www.youtube-nocookie.com/embed/'.$id.'?autoplay=1&rel=0' : null;
    }

    public function thumbnailUrl(): ?string
    {
        if ($this->thumbnail) {
            return asset($this->thumbnail);
        }

        $id = $this->youtubeVideoId();

        return $id ? 'https://img.youtube.com/vi/'.$id.'/hqdefault.jpg' : null;
    }
}
