<?php

declare(strict_types=1);

use App\Http\Controllers\Recipes\RecipeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [RecipeController::class, 'index'])->name('recipe.index');

Route::get('{recipe}', [RecipeController::class, 'show'])->name('recipe.show');
Route::get('{recipe}/print', [RecipeController::class, 'print'])->name('recipe.print');
