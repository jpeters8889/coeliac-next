<?php

declare(strict_types=1);

use App\Modules\Shared\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class);
