<?php

declare(strict_types=1);

use App\Http\Controllers\Api\EaterySuggestEditIndexController;
use App\Http\Controllers\Api\EaterySuggestEditStoreController;
use App\Http\Controllers\Api\ReviewImageUploadController;
use App\Http\Controllers\EatingOut\LocationSearchController;
use Illuminate\Support\Facades\Route;

Route::get('{eatery}/suggest-edit', EaterySuggestEditIndexController::class)
    ->name('api.wheretoeat.suggest-edit.get');

Route::post('{eatery}/suggest-edit', EaterySuggestEditStoreController::class)
    ->name('api.wheretoeat.suggest-edit.store');

Route::post('review/image-upload', ReviewImageUploadController::class)
    ->name('api.wheretoeat.review.image-upload');

Route::post('search', LocationSearchController::class)->name('eating-out.search.location');
