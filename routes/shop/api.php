<?php

declare(strict_types=1);

use App\Http\Controllers\Api\Shop\AddressSearch\ShowController;
use App\Http\Controllers\Api\Shop\AddressSearch\StoreController;
use Illuminate\Support\Facades\Route;

Route::post('address-search', StoreController::class)->name('api.shop.address-search');
Route::get('address-search/{id}', ShowController::class)->name('api.shop.address-search.get');
