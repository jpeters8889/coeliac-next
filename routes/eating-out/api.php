<?php

declare(strict_types=1);

use App\Http\Controllers\Api\EateryDetailsController;
use App\Http\Controllers\Api\EaterySuggestEditIndexController;
use App\Http\Controllers\Api\EaterySuggestEditStoreController;
use App\Http\Controllers\Api\EatingOutBrowseApiController;
use App\Http\Controllers\Api\EatingOutBrowseSearchController;
use App\Http\Controllers\Api\EatingOutFeaturesController;
use App\Http\Controllers\Api\ReviewImageUploadController;
use Illuminate\Support\Facades\Route;

Route::get('{eatery}/suggest-edit', EaterySuggestEditIndexController::class)
    ->name('api.wheretoeat.suggest-edit.get');

Route::post('{eatery}/suggest-edit', EaterySuggestEditStoreController::class)
    ->name('api.wheretoeat.suggest-edit.store');

Route::post('review/image-upload', ReviewImageUploadController::class)
    ->name('api.wheretoeat.review.image-upload');

Route::get('features', EatingOutFeaturesController::class)->name('api.wheretoeat.features');

Route::get('browse', EatingOutBrowseApiController::class)->name('api.wheretoeat.browse');

Route::post('browse/search', EatingOutBrowseSearchController::class)->name('api.wheretoeat.browse.search');

Route::get('{eatery}', EateryDetailsController::class)->name('api.wheretoeat.get');
