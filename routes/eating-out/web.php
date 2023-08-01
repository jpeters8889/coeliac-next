<?php

declare(strict_types=1);

use App\Http\Controllers\EatingOut\CountyController;
use App\Http\Controllers\EatingOut\TownController;
use Illuminate\Support\Facades\Route;

Route::get('/{county}', CountyController::class)->name('eating-out.county');
Route::get('/{county}/{town}', TownController::class)->name('eating-out.town');
