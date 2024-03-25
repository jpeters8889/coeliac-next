<?php

declare(strict_types=1);

namespace App\Actions\Shop;

use App\Enums\Shop\OrderState;
use App\Events\Shop\OrderCancelledEvent;
use App\Models\Shop\ShopOrder;
use App\Models\Shop\ShopOrderItem;
use App\Models\Shop\ShopProductVariant;

class CancelOrderAction
{
    public function handle(ShopOrder $order): void
    {
        $order->load(['items', 'items.variant']);
        $order->update(['state_id' => OrderState::CANCELLED]);

        $order->items->each(function (ShopOrderItem $item): void {
            /** @var ShopProductVariant $variant */
            $variant = $item->variant;

            $variant->increment('quantity', $item->quantity);
        });

        OrderCancelledEvent::dispatch($order);
    }
}
