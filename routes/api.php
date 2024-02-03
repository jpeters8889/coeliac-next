<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::prefix('shop')->group(base_path('routes/shop/api.php'));
Route::prefix('wheretoeat')->group(base_path('routes/eating-out/api.php'));
