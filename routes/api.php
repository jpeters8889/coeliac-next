<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::prefix('blogs')->group(base_path('routes/blogs/api.php'));
Route::prefix('recipes')->group(base_path('routes/recipes/api.php'));
Route::prefix('shop')->group(base_path('routes/shop/api.php'));
Route::prefix('wheretoeat')->group(base_path('routes/eating-out/api.php'));

Route::get('app-request-token', fn () => ['token' => csrf_token()]);
