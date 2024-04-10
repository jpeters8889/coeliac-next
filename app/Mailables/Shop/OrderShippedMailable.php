<?php

declare(strict_types=1);

namespace App\Mailables\Shop;

use App\Infrastructure\MjmlMessage;

class OrderShippedMailable extends BaseShopMailable
{
    public function toMail(): MjmlMessage
    {
        return MjmlMessage::make()
            ->subject('Your Coeliac Sanctuary order is on its way!')
            ->mjml('mailables.mjml.shop.order-shipped', $this->baseData([
                'reason' => 'to let you know your Coeliac Sanctuary order is on its way!',
            ]));
    }
}
