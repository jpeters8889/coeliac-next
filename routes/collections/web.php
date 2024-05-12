<?php

declare(strict_types=1);

use App\Http\Controllers\Collections\IndexController;
use App\Http\Controllers\Collections\ShowController;
use Illuminate\Support\Facades\Route;

Route::get('/', IndexController::class)->name('collection.index');
Route::get('{collection}', ShowController::class)->name('collection.show');
