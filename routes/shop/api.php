<?php

declare(strict_types=1);

use App\Http\Controllers\Shop\AddressSearchController;
use App\Http\Controllers\Shop\AddressSearchGetController;
use Illuminate\Support\Facades\Route;

Route::post('address-search', AddressSearchController::class)->name('api.shop.address-search');
Route::get('address-search/{id}', AddressSearchGetController::class)->name('api.shop.address-search.get');
