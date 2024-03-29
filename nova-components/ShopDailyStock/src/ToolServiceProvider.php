<?php

declare(strict_types=1);

namespace Jpeters8889\ShopDailyStock;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Jpeters8889\ShopDailyStock\Http\Middleware\Authorize;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Http\Middleware\Authenticate;
use Laravel\Nova\Nova;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->app->booted(function (): void {
            $this->routes();
        });

        Nova::serving(function (ServingNova $event): void {
            //
        });
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes(): void
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Nova::router(['nova', Authenticate::class, Authorize::class], 'shop-daily-stock')
            ->group(__DIR__ . '/../routes/inertia.php');

        Route::middleware(['nova', Authorize::class])
            ->prefix('nova-vendor/shop-daily-stock')
            ->group(__DIR__ . '/../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }
}
