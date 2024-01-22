<?php

declare(strict_types=1);

namespace App\Actions\Shop;

use App\Enums\Shop\OrderState;
use App\Models\Shop\ShopOrder;

class ResolveBasketAction
{
    public function handle(?string $token = null): ShopOrder
    {
        if ($token) {
            return ShopOrder::query()
                ->where('token', $token)
                ->where('state_id', OrderState::BASKET)
                ->firstOrCreate();
        }

        return ShopOrder::create();
    }
}
