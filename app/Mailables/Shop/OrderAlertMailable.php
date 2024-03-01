<?php

declare(strict_types=1);

namespace App\Mailables\Shop;

use App\Infrastructure\MjmlMessage;

class OrderAlertMailable extends BaseShopMailable
{
    public function toMail(): MjmlMessage
    {
        return MjmlMessage::make()
            ->subject('Coeliac Sanctuary - New Order')
            ->mjml('mailables.mjml.shop.order-alert', $this->baseData());
    }
}
