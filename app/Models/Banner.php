<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    public const PLACEMENTS = [
        'hero' => 'Hero Slider',
        'signature' => 'Signature Edit',
        'makhana' => 'Makhana',
        'promotional' => 'Promotional Banner',
        'other' => 'Other Homepage Banner',
    ];

    protected $fillable = [
        'image',
        'mobile_image',
        'image_width',
        'image_height',
        'mobile_image_width',
        'mobile_image_height',
        'placement',
        'title',
        'subtitle',
        'cta_text',
        'alt_text',
        'link_url',
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

    public function desktopDimensions(): ?array
    {
        return $this->dimensionsFor($this->image, $this->image_width, $this->image_height);
    }

    public function mobileDimensions(): ?array
    {
        return $this->dimensionsFor($this->mobile_image, $this->mobile_image_width, $this->mobile_image_height);
    }

    public function placementLabel(): string
    {
        return self::PLACEMENTS[$this->placement] ?? self::PLACEMENTS['other'];
    }

    public function destinationUrl(): ?string
    {
        $destination = trim((string) $this->link_url);
        if ($destination === '') {
            return null;
        }

        if (str_starts_with($destination, '/') && ! str_starts_with($destination, '//') && ! str_contains($destination, '\\')) {
            return url(ltrim($destination, '/'));
        }

        $scheme = parse_url($destination, PHP_URL_SCHEME);

        return filter_var($destination, FILTER_VALIDATE_URL)
            && in_array(strtolower((string) $scheme), ['http', 'https'], true)
            ? $destination
            : null;
    }

    private function dimensionsFor(?string $image, ?int $width, ?int $height): ?array
    {
        if ($width && $height) {
            return ['width' => $width, 'height' => $height];
        }

        if (! $image || ! str_starts_with($image, 'uploads/banners/')) {
            return null;
        }

        $path = public_path($image);
        if (! is_file($path)) {
            return null;
        }

        $size = @getimagesize($path);
        if (! $size || empty($size[0]) || empty($size[1])) {
            return null;
        }

        return ['width' => (int) $size[0], 'height' => (int) $size[1]];
    }
}
