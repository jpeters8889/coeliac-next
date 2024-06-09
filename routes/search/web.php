<?php

declare(strict_types=1);

use App\Http\Controllers\Search\IndexController;
use Illuminate\Support\Facades\Route;

Route::get('/', IndexController::class)->name('search.index');
