<?php

declare(strict_types=1);

namespace App\Actions\Shop;

use App\Enums\Shop\OrderState;
use App\Models\Shop\ShopOrder;

class CheckForPendingOrderAction
{
    public function handle(?string $token = null): ?ShopOrder
    {
        if ($token) {
            $order = ShopOrder::query()
                ->where('token', $token)
                ->where('state_id', OrderState::PENDING)
                ->first();

            if ($order) {
                $order->update(['state_id' => OrderState::BASKET]);

                return $order;
            }
        }

        return null;
    }
}
