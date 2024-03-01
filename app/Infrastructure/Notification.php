<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Models\Shop\ShopCustomer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification as BaseNotification;

abstract class Notification extends BaseNotification implements ShouldQueue
{
    use Queueable;

    protected string $key = '';

    protected ?Carbon $date = null;

    public function forceDate(Carbon $date): void
    {
        $this->date = $date;
    }

    public function setKey(string $key): static
    {
        $this->key = $key;

        return $this;
    }

    public function via(): array
    {
        return ['mail'];
    }

    abstract public function toMail(User|ShopCustomer|AnonymousNotifiable|null $notifiable = null): MailMessage;
}
