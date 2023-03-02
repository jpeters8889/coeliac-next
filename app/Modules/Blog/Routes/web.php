<?php

declare(strict_types=1);

use App\Modules\Blog\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BlogController::class, 'index'])->name('blog.index');
Route::get('/tags/{tag}', [BlogController::class, 'index'])->name('blog.index.tags');
