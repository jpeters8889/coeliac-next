<?php

declare(strict_types=1);

namespace Jpeters8889\EateryOpeningTimes;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class FieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Nova::serving(function (ServingNova $event): void {
            Nova::script('eatery-opening-times', __DIR__ . '/../dist/js/field.js');
            Nova::style('eatery-opening-times', __DIR__ . '/../dist/css/field.css');
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
