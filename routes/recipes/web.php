<?php

declare(strict_types=1);

use App\Http\Controllers\Recipes\RecipeIndexController;
use App\Http\Controllers\Recipes\RecipePrintController;
use App\Http\Controllers\Recipes\RecipeShowController;
use Illuminate\Support\Facades\Route;

Route::get('/', RecipeIndexController::class)->name('recipe.index');

Route::get('{recipe}', RecipeShowController::class)->name('recipe.show');
Route::get('{recipe}/print', RecipePrintController::class)->name('recipe.print');
