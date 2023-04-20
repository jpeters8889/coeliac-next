<?php

declare(strict_types=1);

use App\Modules\Shared\Http\Controllers\CommentsController;
use App\Modules\Shared\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::post('comments', CommentsController::class)->name('comments.create');
