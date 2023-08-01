<?php

declare(strict_types=1);

use App\Http\Controllers\Collections\CollectionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CollectionController::class, 'index'])->name('collection.index');
Route::get('{collection}', [CollectionController::class, 'show'])->name('collection.show');
