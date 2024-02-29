<?php

declare(strict_types=1);

namespace App\Events\Shop;

use App\Models\Shop\ShopOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;

class OrderPaidEvent implements ShouldQueue
{
    use Dispatchable;
    use Queueable;

    public function __construct(public ShopOrder $order)
    {
        //
    }
}
