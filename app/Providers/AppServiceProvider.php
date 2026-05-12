<?php

namespace App\Providers;

use App\Models\Place;
use App\Services\RecommendationScorer;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(RecommendationScorer::class);
    }

    public function boot(): void
    {
        // Bagikan daftar kota ke semua view (cache 1 jam)
        view()->composer('*', function ($view) {
            if (request()->routeIs('places.*') || request()->routeIs('home')) {
                $cities = Cache::remember('available_cities', 3600, fn () => Place::where('status', 'active')
                    ->distinct()
                    ->orderBy('city')
                    ->pluck('city')
                );
                $view->with('availableCities', $cities);
            }
        });
    }
}
