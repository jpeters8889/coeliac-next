<?php

declare(strict_types=1);

use App\Http\Controllers\EatingOut\CountyController;
use App\Http\Controllers\EatingOut\EateryCreateReportController;
use App\Http\Controllers\EatingOut\EateryCreateReviewController;
use App\Http\Controllers\EatingOut\EateryDetailsController;
use App\Http\Controllers\EatingOut\EaterySearchResultsController;
use App\Http\Controllers\EatingOut\EatingOutController;
use App\Http\Controllers\EatingOut\NationwideController;
use App\Http\Controllers\EatingOut\SearchCreateController;
use App\Http\Controllers\EatingOut\TownController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Support\Facades\Route;

$prefixedEateryRoutes = function (string $namePrefix): callable {
    return function () use ($namePrefix): void {
        Route::get('/', EateryDetailsController::class)->name($namePrefix);

        Route::post('/reviews', EateryCreateReviewController::class)
            ->middleware([HandlePrecognitiveRequests::class])
            ->name("{$namePrefix}.reviews.create");

        Route::post('/report', EateryCreateReportController::class)
            ->middleware([HandlePrecognitiveRequests::class])
            ->name("{$namePrefix}.report.create");
    };
};

Route::get('/', EatingOutController::class)->name('eating-out.index');

Route::post('/search', SearchCreateController::class)->name('eating-out.search.create');
Route::post('/search/{eaterySearchTerm}', EaterySearchResultsController::class)->name('eating-out.search.show');

Route::get('/nationwide', NationwideController::class)->name('eating-out.nationwide');
Route::prefix('/nationwide/{eatery}')->group(
    $prefixedEateryRoutes('eating-out.nationwide.show')
);
Route::prefix('/nationwide/{eatery}/{nationwideBranch}')->group(
    $prefixedEateryRoutes('eating-out.nationwide.show.branch')
);

Route::get('/{county}', CountyController::class)->name('eating-out.county');
Route::get('/{county}/{town}', TownController::class)->name('eating-out.town');

Route::prefix('/{county}/{town}/{eatery}')->group($prefixedEateryRoutes('eating-out.show'));
