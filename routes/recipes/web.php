<?php

declare(strict_types=1);

use App\Http\Controllers\Recipes\IndexController;
use App\Http\Controllers\Recipes\Print\ShowController as PrintController;
use App\Http\Controllers\Recipes\ShowController;
use Illuminate\Support\Facades\Route;

Route::get('/', IndexController::class)->name('recipe.index');

Route::get('{recipe}', ShowController::class)->name('recipe.show');
Route::get('{recipe}/print', PrintController::class)->name('recipe.print');
