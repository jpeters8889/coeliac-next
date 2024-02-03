<?php

declare(strict_types=1);

use App\Http\Controllers\Shop\ShopAddToBasketController;
use App\Http\Controllers\Shop\ShopBasketPatchController;
use App\Http\Controllers\Shop\ShopCategoryController;
use App\Http\Controllers\Shop\ShopCheckoutController;
use App\Http\Controllers\Shop\ShopIndexController;
use App\Http\Controllers\Shop\ShopProductController;
use App\Http\Controllers\Shop\ShopRemoveFromBasketController;
use App\Http\Middleware\ShopBasketTokenMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware(ShopBasketTokenMiddleware::class)->group(function (): void {
    Route::get('/', ShopIndexController::class)->name('shop.index');

    Route::prefix('/basket')->group(function (): void {
        Route::get('/', ShopCheckoutController::class)->name('shop.basket.checkout');
        Route::put('/', ShopAddToBasketController::class)->name('shop.basket.add');
        Route::patch('/', ShopBasketPatchController::class)->name('shop.basket.patch');

        Route::delete('/{item}', ShopRemoveFromBasketController::class)->name('shop.basket.remove');
    });

    Route::get('/{category}', ShopCategoryController::class)->name('shop.category');
    Route::get('/product/{product}', ShopProductController::class)->name('shop.product');
});
