<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Gate;

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
        Gate::define('access-admin', fn ($user) => $user->canAccessAdmin());
        Gate::define('manage-orders', fn ($user) => $user->canManageOrders());
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
        View::composer('backend.layout.app', function ($view): void {
            $user = auth()->user();
            $notifications = collect();
            $unreadNotificationCount = 0;
            if ($user && $user->canManageOrders()) {
                try {
                    $notifications = $user->notifications()->latest()->limit(6)->get();
                    $unreadNotificationCount = $user->unreadNotifications()->count();
                } catch (\Throwable $exception) { report($exception); }
            }
            $view->with(compact('notifications','unreadNotificationCount'));
        });
    }
}
