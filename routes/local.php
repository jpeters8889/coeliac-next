<?php

declare(strict_types=1);

use App\Enums\Shop\OrderState;
use App\Models\Shop\ShopOrder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Route;
use Spatie\Mjml\Mjml;

Route::get('/mail/shop/order-confirmed/{orderId?}', function (?int $orderId = null): string {
    $order = ShopOrder::query()
        ->where('state_id', OrderState::PAID)
        ->with(['items', 'items.product.media', 'payment', 'customer', 'address'])
        ->when(
            $orderId,
            fn (Builder $builder) => $builder->findOrFail($orderId),
            fn (Builder $builder) => $builder->latest()->first(),
        );

    $content = view('mailables.shop.order-complete', [
        'key' => 'foo',
        'date' => now(),
        'order' => $order,
    ])->render();

    return Mjml::new()->toHtml($content);
});
