<?php

namespace Tests\Feature;

use App\Models\Banner;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class HomeBannerManagementTest extends TestCase
{
    use RefreshDatabase;

    private array $testImagePaths = [];

    protected function tearDown(): void
    {
        if (\Illuminate\Support\Facades\Schema::hasTable('banners')) {
            foreach (Banner::query()->get(['image', 'mobile_image']) as $banner) {
                foreach ([$banner->image, $banner->mobile_image] as $relativePath) {
                    if ($relativePath && str_starts_with($relativePath, 'uploads/banners/')) {
                        $this->testImagePaths[] = public_path($relativePath);
                    }
                }
            }
        }

        foreach ($this->testImagePaths as $path) {
            if (File::exists($path)) {
                File::delete($path);
            }
        }

        parent::tearDown();
    }

    public function test_homepage_renders_only_active_banners_in_their_assigned_placements_and_order(): void
    {
        $this->banner(['placement' => 'hero', 'sort_order' => 20, 'alt_text' => 'Hero second']);
        $this->banner(['placement' => 'hero', 'sort_order' => 10, 'alt_text' => 'Hero first']);
        $this->banner(['placement' => 'signature', 'alt_text' => 'Signature campaign', 'link_url' => '/shop']);
        $this->banner(['placement' => 'makhana', 'alt_text' => 'Inactive banner sentinel', 'is_active' => false]);

        $response = $this->get('/');

        $this->assertSame('signature', $response->viewData('signatureBanner')?->placement);
        $response->assertOk()
            ->assertSee('Hero first')
            ->assertSee('Hero second')
            ->assertSee('Signature campaign')
            ->assertDontSee('Inactive banner sentinel');
        $this->assertSame(
            ['Hero first', 'Hero second'],
            $response->viewData('heroBanners')->pluck('alt_text')->all()
        );
        $this->assertSame('signature', $response->viewData('signatureBanner')->placement);
        $this->assertSame('makhana', $response->viewData('makhanaBanner')->placement);
        $response->assertSee('href="'.url('/shop').'"', false);
    }

    public function test_legacy_banner_with_an_empty_placement_remains_in_the_hero_carousel(): void
    {
        $legacyBanner = $this->banner(['placement' => 'hero', 'alt_text' => 'Legacy header banner']);
        $legacyBanner->forceFill(['placement' => ''])->save();

        $response = $this->get('/');

        $response->assertOk()->assertSee('Legacy header banner');
        $this->assertSame([$legacyBanner->id], $response->viewData('heroBanners')->pluck('id')->all());
    }

    public function test_admin_can_upload_and_configure_a_banner_with_a_separate_mobile_image(): void
    {
        $this->actingAs($this->admin())
            ->post(route('banners.store'), [
                'image' => UploadedFile::fake()->image('desktop.jpg', 1200, 500),
                'mobile_image' => UploadedFile::fake()->image('mobile.jpg', 600, 800),
                'placement' => 'signature',
                'title' => 'Signature campaign',
                'subtitle' => 'Handcrafted for every occasion',
                'cta_text' => 'Explore',
                'alt_text' => 'Signature artwork',
                'link_url' => '/shop',
                'sort_order' => 4,
                'is_active' => 1,
            ])
            ->assertRedirect(route('banners.index'));

        $banner = Banner::query()->where('title', 'Signature campaign')->firstOrFail();
        $this->testImagePaths[] = public_path($banner->image);
        $this->testImagePaths[] = public_path($banner->mobile_image);
        $this->assertSame('Signature campaign', $banner->title);
        $this->assertSame(['width' => 1200, 'height' => 500], $banner->desktopDimensions());
        $this->assertSame(['width' => 600, 'height' => 800], $banner->mobileDimensions());
    }

    public function test_admin_banner_forms_and_listing_expose_placement_and_responsive_previews(): void
    {
        $banner = $this->banner(['placement' => 'makhana', 'mobile_image' => 'frontend/images/mobile-banner.png']);
        $this->actingAs($this->admin());

        $this->get(route('banners.create'))->assertOk()
            ->assertSee('name="placement"', false)
            ->assertSee('name="mobile_image"', false)
            ->assertSee('name="cta_text"', false);
        $this->get(route('banners.edit', $banner))->assertOk()
            ->assertSee('Makhana', false)
            ->assertSee('banner-preview-mobile', false);
        $this->get(route('banners.index'))->assertOk()->assertSee('Makhana')->assertSee('Placement');
    }

    public function test_replacing_and_deleting_managed_uploads_preserves_legacy_assets(): void
    {
        $banner = $this->banner(['placement' => 'promotional']);
        $legacyImage = public_path($banner->image);
        $this->assertFileExists($legacyImage);

        $this->actingAs($this->admin())
            ->put(route('banners.update', $banner), [
                'image' => UploadedFile::fake()->image('replacement.jpg', 1440, 520),
                'mobile_image' => UploadedFile::fake()->image('mobile.jpg', 650, 900),
                'placement' => 'promotional',
                'alt_text' => 'Updated campaign',
                'link_url' => '/shop',
                'sort_order' => 1,
                'is_active' => 1,
            ])
            ->assertRedirect(route('banners.index'));

        $banner->refresh();
        $desktopUpload = public_path($banner->image);
        $mobileUpload = public_path($banner->mobile_image);
        $this->testImagePaths[] = $desktopUpload;
        $this->testImagePaths[] = $mobileUpload;
        $this->assertFileExists($desktopUpload);
        $this->assertFileExists($mobileUpload);
        $this->assertFileExists($legacyImage);
        $this->assertSame(1440, $banner->image_width);
        $this->assertSame(900, $banner->mobile_image_height);

        $this->delete(route('banners.destroy', $banner))->assertRedirect(route('banners.index'));
        $this->assertFileDoesNotExist($desktopUpload);
        $this->assertFileDoesNotExist($mobileUpload);
        $this->assertFileExists($legacyImage);
    }

    public function test_admin_can_change_banner_order_and_activation_and_remove_mobile_fallback(): void
    {
        $banner = $this->banner([
            'placement' => 'hero',
            'mobile_image' => 'frontend/images/house-of-maithili.png',
            'mobile_image_width' => 320,
            'mobile_image_height' => 120,
        ]);
        $this->actingAs($this->admin());

        $this->put(route('banners.update', $banner), [
            'placement' => 'hero',
            'sort_order' => 7,
            'is_active' => 0,
            'remove_mobile_image' => 1,
        ])->assertRedirect(route('banners.index'));

        $banner->refresh();
        $this->assertFalse($banner->is_active);
        $this->assertSame(7, $banner->sort_order);
        $this->assertNull($banner->mobile_image);
        $this->assertFileExists(public_path('frontend/images/house-of-maithili.png'));

        $this->put(route('banners.update', $banner), [
            'placement' => 'hero',
            'sort_order' => 2,
            'is_active' => 1,
        ])->assertRedirect(route('banners.index'));
        $this->assertTrue($banner->fresh()->is_active);
        $this->assertSame(2, $banner->fresh()->sort_order);
    }

    public function test_banner_destination_rejects_unsafe_schemes_when_rendering_legacy_values(): void
    {
        config(['app.url' => 'https://example.test']);
        $banner = new Banner(['link_url' => 'javascript:alert(1)']);

        $this->assertNull($banner->destinationUrl());
        $this->assertSame(url('/shop'), (new Banner(['link_url' => '/shop']))->destinationUrl());
    }

    private function banner(array $attributes = []): Banner
    {
        return Banner::create(array_merge([
            'image' => 'frontend/images/house-of-maithili.png',
            'placement' => 'hero',
            'alt_text' => 'Campaign artwork',
            'is_active' => true,
            'sort_order' => 0,
        ], $attributes));
    }

    private function admin(): User
    {
        return User::factory()->create([
            'email' => User::AUTHORIZED_ADMIN_EMAIL,
            'email_verified_at' => now(),
        ]);
    }
}
