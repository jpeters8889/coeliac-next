<?php

declare(strict_types=1);

use App\Http\Controllers\Comments\CommentsController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::prefix('blog')->group(base_path('routes/blogs/web.php'));
Route::prefix('collection')->group(base_path('routes/collections/web.php'));
Route::prefix('recipe')->group(base_path('routes/recipes/web.php'));
Route::prefix('')->group(base_path('routes/eating-out/web.php'));

Route::get('/', HomeController::class)->name('home');

Route::post('comments', CommentsController::class)->name('comments.create');
