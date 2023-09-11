<?php

declare(strict_types=1);

use App\Http\Controllers\EatingOut\CountyController;
use App\Http\Controllers\EatingOut\EateryCreateReportController;
use App\Http\Controllers\EatingOut\EateryCreateReviewController;
use App\Http\Controllers\EatingOut\EateryDetailsController;
use App\Http\Controllers\EatingOut\TownController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Support\Facades\Route;

Route::get('/{county}', CountyController::class)->name('eating-out.county');
Route::get('/{county}/{town}', TownController::class)->name('eating-out.town');

Route::prefix('/{county}/{town}/{eatery}')->group(function (): void {
    Route::get('/', EateryDetailsController::class)->name('eating-out.show');

    Route::post('/reviews', EateryCreateReviewController::class)
        ->middleware([HandlePrecognitiveRequests::class])
        ->name('eating-out.show.reviews.create');

    Route::post('/report', EateryCreateReportController::class)
        ->middleware([HandlePrecognitiveRequests::class])
        ->name('eating-out.show.report.create');
});
