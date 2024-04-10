<?php

declare(strict_types=1);

namespace Tests\Unit\Events\Shop;

use App\Events\Shop\OrderCancelledEvent;
use App\Events\Shop\OrderPaidEvent;
use App\Events\Shop\OrderShippedEvent;
use App\Listeners\Shop\SendOrderCancellationNotification;
use App\Listeners\Shop\SendOrderConfirmationMails;
use App\Listeners\Shop\SendOrderShippedNotification;
use App\Models\Shop\ShopOrder;
use Tests\TestCase;

class OrderCancelledEventTest extends TestCase
{
    /** @test */
    public function itIsHandledByTheSendOrderShippedNotificationListener(): void
    {
        $this->mock(SendOrderCancellationNotification::class)
            ->shouldReceive('handle')
            ->once();

        OrderCancelledEvent::dispatch(new ShopOrder());
    }
}
