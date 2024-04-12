<?php

declare(strict_types=1);

namespace App\Providers;

use App\Events\EatingOut\EateryReviewApprovedEvent;
use App\Events\Shop\OrderCancelledEvent;
use App\Events\Shop\OrderPaidEvent;
use App\Events\Shop\OrderShippedEvent;
use App\Listeners\EatingOut\SendEateryReviewApprovedNotification;
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
        // Eating Out
        EateryReviewApprovedEvent::class => [
            SendEateryReviewApprovedNotification::class,
        ],

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
    ];
}
