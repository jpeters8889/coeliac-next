<?php

declare(strict_types=1);

use App\Http\Controllers\Shop\ShopAddToBasketController;
use App\Http\Controllers\Shop\ShopCategoryController;
use App\Http\Controllers\Shop\ShopIndexController;
use App\Http\Controllers\Shop\ShopProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', ShopIndexController::class)->name('shop.index');
Route::post('/basket', ShopAddToBasketController::class)->name('shop.basket.add');
Route::get('/{category}', ShopCategoryController::class)->name('shop.category');
Route::get('/product/{product}', ShopProductController::class)->name('shop.product');
