<?php

declare(strict_types=1);

namespace App\Events\Shop;

use App\Models\Shop\ShopOrder;
use Illuminate\Foundation\Events\Dispatchable;

class OrderPaidEvent
{
    use Dispatchable;

    public function __construct(ShopOrder $order)
    {
        //
    }
}
