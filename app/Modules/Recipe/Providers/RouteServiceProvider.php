<?php

declare(strict_types=1);

namespace App\Modules\Recipe\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->routes(function (): void {
            Route::middleware('web')->prefix('recipe')->group(app_path('Modules/Recipe/Routes/web.php'));
        });
    }
}
