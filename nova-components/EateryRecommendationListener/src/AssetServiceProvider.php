<?php

declare(strict_types=1);

namespace Jpeters8889\EateryRecommendationListener;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class AssetServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Nova::serving(function (ServingNova $event): void {
            Nova::script('eatery-recommendation-listener', __DIR__ . '/../dist/js/asset.js');
            Nova::style('eatery-recommendation-listener', __DIR__ . '/../dist/css/asset.css');
        });
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
}
