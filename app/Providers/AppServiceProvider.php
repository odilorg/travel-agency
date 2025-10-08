<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Destination;

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
        // Share site settings globally with all views
        View::composer('*', \App\Http\ViewComposers\SiteSettingComposer::class);

        // Share featured destinations with header and footer
        View::composer(['partials.header', 'partials.footer'], function ($view) {
            $navFeaturedDestinations = cache()->remember('nav_featured_destinations_v1', 86400, function () {
                return Destination::query()
                    ->where('status', 'published')
                    ->where('is_featured', true)
                    ->orderBy('order')
                    ->orderBy('name')
                    ->take(12)
                    ->get(['id', 'name', 'slug']);
            });

            $view->with('navFeaturedDestinations', $navFeaturedDestinations);
        });
    }
}
