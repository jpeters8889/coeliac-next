<?php

declare(strict_types=1);

namespace App\Mailables\Shop;

use App\Infrastructure\MjmlMessage;

class OrderCancelledMailable extends BaseShopMailable
{
    public function toMail(): MjmlMessage
    {
        return MjmlMessage::make()
            ->subject('Your Coeliac Sanctuary order has been cancelled')
            ->mjml('mailables.mjml.shop.order-cancelled', $this->baseData([
                'reason' => 'to let you know your Coeliac Sanctuary order has been cancelled.',
            ]));
    }
}
