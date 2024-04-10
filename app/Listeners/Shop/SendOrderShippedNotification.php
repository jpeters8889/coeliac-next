<?php

declare(strict_types=1);

namespace App\Listeners\Shop;

use App\Events\Shop\OrderPaidEvent;
use App\Events\Shop\OrderShippedEvent;
use App\Mailables\Shop\OrderShippedMailable;
use App\Models\Shop\ShopCustomer;
use App\Models\Shop\ShopOrder;
use App\Notifications\Shop\OrderShippedNotification;

class SendOrderShippedNotification
{
    public function handle(OrderShippedEvent $event): void
    {
        /** @var ShopOrder $order */
        $order = $event->order;

        /** @var ShopCustomer $customer */
        $customer = $order->customer;

        $customer->notify(new OrderShippedNotification($order));
    }
}
