<?php

declare(strict_types=1);

namespace App\Providers;

use App\Events\ContactFormSubmittedEvent;
use App\Events\Shop\OrderCancelledEvent;
use App\Events\Shop\OrderPaidEvent;
use App\Events\Shop\OrderShippedEvent;
use App\Listeners\SendContactFormListener;
use App\Listeners\Shop\SendOrderCancellationNotification;
use App\Listeners\Shop\SendOrderConfirmationMails;
use App\Listeners\Shop\SendOrderShippedNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        // Shop
        OrderPaidEvent::class => [
            SendOrderConfirmationMails::class,
        ],

        OrderShippedEvent::class => [
            SendOrderShippedNotification::class,
        ],

        OrderCancelledEvent::class => [
            SendOrderCancellationNotification::class,
        ],
        ContactFormSubmittedEvent::class => [
            SendContactFormListener::class,
        ],
    ];
}
