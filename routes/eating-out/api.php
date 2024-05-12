<?php

declare(strict_types=1);

use App\Http\Controllers\Api\EatingOut\Browse\IndexController as BrowseIndexController;
use App\Http\Controllers\Api\EatingOut\Browse\Search\StoreController as BrowseSearchStoreController;
use App\Http\Controllers\Api\EatingOut\Details\ShowController as DetailsShowController;
use App\Http\Controllers\Api\EatingOut\Features\IndexController as FeatureIndexController;
use App\Http\Controllers\Api\EatingOut\ReviewImages\StoreController as ReviewImagesStoreController;
use App\Http\Controllers\Api\EatingOut\SuggestEdits\IndexController as SuggestEditsIndexController;
use App\Http\Controllers\Api\EatingOut\SuggestEdits\StoreController as SuggestEditsStoreController;
use Illuminate\Support\Facades\Route;

Route::get('{eatery}/suggest-edit', SuggestEditsIndexController::class)
    ->name('api.wheretoeat.suggest-edit.get');

Route::post('{eatery}/suggest-edit', SuggestEditsStoreController::class)
    ->name('api.wheretoeat.suggest-edit.store');

Route::post('review/image-upload', ReviewImagesStoreController::class)
    ->name('api.wheretoeat.review.image-upload');

Route::get('features', FeatureIndexController::class)->name('api.wheretoeat.features');

Route::get('browse', BrowseIndexController::class)->name('api.wheretoeat.browse');

Route::post('browse/search', BrowseSearchStoreController::class)->name('api.wheretoeat.browse.search');

Route::get('{eatery}', DetailsShowController::class)->name('api.wheretoeat.get');
