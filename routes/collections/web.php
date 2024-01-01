<?php

declare(strict_types=1);

use App\Http\Controllers\Collections\CollectionIndexController;
use App\Http\Controllers\Collections\CollectionShowController;
use Illuminate\Support\Facades\Route;

Route::get('/', CollectionIndexController::class)->name('collection.index');
Route::get('{collection}', CollectionShowController::class)->name('collection.show');
