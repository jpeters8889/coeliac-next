<?php

declare(strict_types=1);

namespace App\Modules\Blog\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->routes(function (): void {
            Route::middleware('web')->prefix('blog')->group(app_path('Modules/Blog/Routes/web.php'));
        });
    }
}
