<?php

declare(strict_types=1);

use App\Modules\Collection\Http\Controllers\CollectionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CollectionController::class, 'index'])->name('collection.index');
