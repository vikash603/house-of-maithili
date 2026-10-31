<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Banner;
use App\Models\Story;
use App\Models\HomeHighlight;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $testimonials = collect();
        $homeHighlights = collect();
        $banners = collect();
        $stories = collect();

        try {
            $banners = Banner::query()->orderBy('sort_order')->orderBy('id')->get();
        } catch (\Throwable $exception) {
            report($exception);
        }

        try {
            $stories = Story::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderByDesc('updated_at')
                ->get();
        } catch (\Throwable $exception) {
            report($exception);
        }

        try {
            $homeHighlights = HomeHighlight::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get();
        } catch (\Throwable $exception) {
            report($exception);
        }

        try {
            $testimonials = Testimonial::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderByDesc('updated_at')
                ->limit(12)
                ->get();
        } catch (\Throwable $exception) {
            report($exception);
        }

        try {
            $shopCategories = Category::query()
                ->where('status', 1)
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get();

            $bestsellers = Product::query()
                ->whereHas('category', function ($query) {
                    $query->where('status', 1);
                })
                ->where('status', 1)
                ->where(function ($query) {
                    $query->where(function ($standardProduct) {
                        $standardProduct->whereDoesntHave('variants')
                            ->where(fn ($availability) => $availability->where('stock', '>', 0)->orWhere('is_made_to_order', true));
                    })->orWhere(function ($variantProduct) {
                        $variantProduct->whereHas('variants', fn ($variants) => $variants->where('is_active', true))
                            ->where(function ($availability) {
                                $availability->where('is_made_to_order', true)
                                    ->orWhereHas('variants', fn ($variants) => $variants->where('is_active', true)->where('stock', '>', 0));
                            });
                    });
                })
                ->with(['category', 'images', 'variants' => fn ($query) => $query->where('is_active', true)->orderBy('id')])
                ->withCount(['variants' => fn ($query) => $query->where('is_active', true)])
                ->orderByDesc('is_featured')
                ->latest()
                ->limit(6)
                ->get();
        } catch (\Throwable $exception) {
            report($exception);
            $bestsellers = collect();
            $shopCategories = collect();
        }

        return view('frontend.index', compact('bestsellers', 'shopCategories', 'testimonials', 'homeHighlights', 'banners', 'stories'));
    }
    
}
