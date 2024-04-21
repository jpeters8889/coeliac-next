<?php

declare(strict_types=1);

namespace App\Notifications\Shop;

use App\Infrastructure\MjmlMessage;
use App\Infrastructure\Notification;
use App\Mailables\Shop\ReviewOrderInvitationMailable;
use App\Models\Shop\ShopCustomer;
use App\Models\Shop\ShopOrder;
use App\Models\User;
use Illuminate\Notifications\AnonymousNotifiable;

class ReviewOrderInvitationNotification extends Notification
{
    public function __construct(protected ShopOrder $order, protected string $delayText)
    {
        //
    }

    public function toMail(User|ShopCustomer|AnonymousNotifiable|null $notifiable = null): MjmlMessage
    {
        return ReviewOrderInvitationMailable::make($this->order, $this->delayText, $this->key);
    }
}
