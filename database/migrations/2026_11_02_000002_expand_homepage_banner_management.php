<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('banners', function (Blueprint $table): void {
            // Existing records remain hero slides unless an administrator changes their placement.
            $table->string('placement', 32)->default('hero');
            $table->string('mobile_image')->nullable();
            $table->string('title', 160)->nullable();
            $table->text('subtitle')->nullable();
            $table->string('cta_text', 80)->nullable();
            $table->unsignedInteger('image_width')->nullable();
            $table->unsignedInteger('image_height')->nullable();
            $table->unsignedInteger('mobile_image_width')->nullable();
            $table->unsignedInteger('mobile_image_height')->nullable();
            $table->index(['placement', 'is_active', 'sort_order'], 'banners_homepage_display_idx');
        });

        DB::table('banners')->orderBy('id')->chunkById(100, function ($banners): void {
            foreach ($banners as $banner) {
                if (! $banner->image || str_contains($banner->image, '..')) {
                    continue;
                }

                $path = public_path($banner->image);
                if (! is_file($path)) {
                    continue;
                }

                $dimensions = @getimagesize($path);
                if ($dimensions && ! empty($dimensions[0]) && ! empty($dimensions[1])) {
                    DB::table('banners')->where('id', $banner->id)->update([
                        'image_width' => (int) $dimensions[0],
                        'image_height' => (int) $dimensions[1],
                    ]);
                }
            }
        });

        // Adopt the two existing hardcoded campaigns as managed banner entries when
        // their original artwork is present. These are presentation settings only;
        // existing banner, customer, product and order rows are left untouched.
        $legacyCampaigns = [
            [
                'image' => 'frontend/images/IMG_8003.PNG',
                'placement' => 'signature',
                'alt_text' => 'The Artisan’s Collection — Rare Artistry, Timeless Elegance. Discover an exclusive collection of handcrafted sarees, celebrating the rich artistic heritage of Bihar through exquisite craftsmanship and timeless design.',
                'link_url' => null,
                'sort_order' => 0,
            ],
            [
                'image' => 'frontend/images/OUR STORY IN MOTION Stories of Artisans, Art & Impact  Watch real stories from our artisans, collections. events and the journey of House of Maithili. (2).png',
                'placement' => 'makhana',
                'alt_text' => 'From the soil of Bihar, with love — House Of Maithili’s handpicked Makhana goodness.',
                'link_url' => '/shop/makhana',
                'sort_order' => 0,
            ],
        ];

        foreach ($legacyCampaigns as $campaign) {
            $imagePath = public_path($campaign['image']);
            if (is_file($imagePath) && ! DB::table('banners')->where('image', $campaign['image'])->exists()) {
                $dimensions = @getimagesize($imagePath);
                $legacyBanner = $campaign + [
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                if ($dimensions && ! empty($dimensions[0]) && ! empty($dimensions[1])) {
                    $legacyBanner['image_width'] = (int) $dimensions[0];
                    $legacyBanner['image_height'] = (int) $dimensions[1];
                }
                DB::table('banners')->insert($legacyBanner);
            }
        }
    }

    public function down(): void
    {
        // Keep banner records created by the migration. They contain presentation
        // configuration that may have since been edited in the admin module.
        Schema::table('banners', function (Blueprint $table): void {
            $table->dropIndex('banners_homepage_display_idx');
            $table->dropColumn([
                'placement',
                'mobile_image',
                'title',
                'subtitle',
                'cta_text',
                'image_width',
                'image_height',
                'mobile_image_width',
                'mobile_image_height',
            ]);
        });
    }
};
