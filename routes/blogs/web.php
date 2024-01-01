<?php

declare(strict_types=1);

use App\Http\Controllers\Blogs\BlogIndexController;
use App\Http\Controllers\Blogs\BlogShowController;
use Illuminate\Support\Facades\Route;

Route::get('/', BlogIndexController::class)->name('blog.index');
Route::get('tags/{tag}', BlogIndexController::class)->name('blog.index.tags');

Route::get('{blog}', BlogShowController::class)->name('blog.show');
