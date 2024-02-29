<?php

declare(strict_types=1);

namespace App\Providers;

use App\Events\Shop\OrderPaidEvent;
use App\Listeners\Shop\SendOrderConfirmationMails;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        OrderPaidEvent::class => [
            SendOrderConfirmationMails::class,
        ],
    ];
}
