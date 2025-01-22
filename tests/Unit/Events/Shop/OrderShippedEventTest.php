<?php

declare(strict_types=1);

namespace Tests\Unit\Events\Shop;

use PHPUnit\Framework\Attributes\Test;
use App\Events\Shop\OrderShippedEvent;
use App\Listeners\Shop\SendOrderShippedNotification;
use App\Models\Shop\ShopOrder;
use Tests\TestCase;

class OrderShippedEventTest extends TestCase
{
    #[Test]
    public function itIsHandledByTheSendOrderShippedNotificationListener(): void
    {
        $this->mock(SendOrderShippedNotification::class)
            ->shouldReceive('handle')
            ->once();

        OrderShippedEvent::dispatch(new ShopOrder());
    }
}
