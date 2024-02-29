<?php

declare(strict_types=1);

namespace Tests\Unit\Events\Shop;

use App\Events\Shop\OrderPaidEvent;
use App\Listeners\Shop\SendOrderConfirmationMails;
use App\Models\Shop\ShopOrder;
use Tests\TestCase;

class OrderPaidEventTest extends TestCase
{
    /** @test */
    public function itIsHandledByTheSendOrderConfirmationMailsListener(): void
    {
        $this->mock(SendOrderConfirmationMails::class)
            ->shouldReceive('handle')
            ->once();

        OrderPaidEvent::dispatch(new ShopOrder());
    }
}
