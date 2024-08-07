<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use App\Infrastructure\MjmlMessage;
use App\Infrastructure\Notification;
use App\Models\Shop\ShopCustomer;
use App\Models\User;
use Illuminate\Notifications\AnonymousNotifiable;

class MockMjmlNotification extends Notification
{
    public function toMail(User|ShopCustomer|AnonymousNotifiable|null $notifiable = null): MjmlMessage
    {
        return MjmlMessage::make('mailables.mjml.layout', [
            'date' => now(),
        ]);
    }
}
