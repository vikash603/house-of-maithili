<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('frontend.layout.app', function ($view): void {
            try {
                $view->with('navCategories', Category::query()
                    ->where('status', true)
                    ->with(['subcategories' => fn ($query) => $query->where('status', true)->orderBy('name')])
                    ->orderBy('sort_order')
                    ->orderBy('name')
                    ->get());
            } catch (\Throwable $exception) {
                report($exception);
                $view->with('navCategories', collect());
            }
        });
    }
}
