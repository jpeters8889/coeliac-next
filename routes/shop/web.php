<?php

declare(strict_types=1);

use App\Http\Controllers\Shop\ReviewMyOrderGetController;
use App\Http\Controllers\Shop\ReviewMyOrderStoreController;
use App\Http\Controllers\Shop\ReviewMyOrderThanksController;
use App\Http\Controllers\Shop\ShopAddToBasketController;
use App\Http\Controllers\Shop\ShopBasketPatchController;
use App\Http\Controllers\Shop\ShopCategoryController;
use App\Http\Controllers\Shop\ShopCheckoutController;
use App\Http\Controllers\Shop\ShopCompleteOrderController;
use App\Http\Controllers\Shop\ShopIndexController;
use App\Http\Controllers\Shop\ShopOrderCompleteController;
use App\Http\Controllers\Shop\ShopProductController;
use App\Http\Controllers\Shop\ShopRemoveDiscountCodeController;
use App\Http\Controllers\Shop\ShopRemoveFromBasketController;
use App\Http\Controllers\Shop\ShopRevertPendingOrderController;
use App\Http\Middleware\ShopBasketTokenMiddleware;
use App\Http\Middleware\ShopHasBasketMiddleware;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Support\Facades\Route;

Route::middleware(ShopBasketTokenMiddleware::class)->group(function (): void {
    Route::get('/', ShopIndexController::class)->name('shop.index');

    Route::prefix('/basket')->group(function (): void {
        Route::get('/', ShopCheckoutController::class)->name('shop.basket.checkout');

        Route::post('/', ShopCompleteOrderController::class)
            ->middleware(ShopHasBasketMiddleware::class)
            ->name('shop.order.complete');

        Route::put('/', ShopAddToBasketController::class)
            ->middleware(HandlePrecognitiveRequests::class)
            ->name('shop.basket.add');

        Route::patch('/', ShopBasketPatchController::class)->name('shop.basket.patch');
        Route::delete('/', ShopRevertPendingOrderController::class)->name('shop.basket.revert');

        Route::get('/done', ShopOrderCompleteController::class)->name('shop.basket.done');

        Route::delete('/discount', ShopRemoveDiscountCodeController::class)->name('shop.basket.discount.remove');
        Route::delete('/{item}', ShopRemoveFromBasketController::class)->name('shop.basket.remove');
    });

    Route::get('/{category}', ShopCategoryController::class)->name('shop.category');
    Route::get('/product/{product}', ShopProductController::class)->name('shop.product');

    Route::get('review-my-order/{invitation}', ReviewMyOrderGetController::class)
        ->middleware(['signed'])
        ->name('shop.review-order');

    Route::get('review-my-order/{invitation}/thanks', ReviewMyOrderThanksController::class)
        ->name('shop.review-order.thanks');

    Route::post('review-my-order/{invitation}', ReviewMyOrderStoreController::class)
        ->middleware(HandlePrecognitiveRequests::class)
        ->name('shop.review-order.store');
});
