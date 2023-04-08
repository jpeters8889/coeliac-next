<?php

declare(strict_types=1);

use App\Modules\Recipe\Http\Controllers\RecipeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [RecipeController::class, 'index'])->name('recipe.index');
