<?php

declare(strict_types=1);

namespace Tests\Unit\Events\Shop;

use PHPUnit\Framework\Attributes\Test;
use App\Events\Shop\OrderCancelledEvent;
use App\Listeners\Shop\SendOrderCancellationNotification;
use App\Models\Shop\ShopOrder;
use Tests\TestCase;

class OrderCancelledEventTest extends TestCase
{
    #[Test]
    public function itIsHandledByTheSendOrderShippedNotificationListener(): void
    {
        $this->mock(SendOrderCancellationNotification::class)
            ->shouldReceive('handle')
            ->once();

        OrderCancelledEvent::dispatch(new ShopOrder());
    }
}
