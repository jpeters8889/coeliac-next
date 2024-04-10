<?php

declare(strict_types=1);

namespace App\Notifications\Shop;

use App\Infrastructure\MjmlMessage;
use App\Infrastructure\Notification;
use App\Mailables\Shop\OrderCancelledMailable;
use App\Models\Shop\ShopCustomer;
use App\Models\Shop\ShopOrder;
use App\Models\User;
use Illuminate\Notifications\AnonymousNotifiable;

class OrderCancelledNotification extends Notification
{
    public function __construct(protected ShopOrder $order)
    {
        //
    }

    public function toMail(User|ShopCustomer|AnonymousNotifiable|null $notifiable = null): MjmlMessage
    {
        return OrderCancelledMailable::make($this->order, $this->key);
    }
}
