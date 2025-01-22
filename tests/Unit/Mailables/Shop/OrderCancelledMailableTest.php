<?php

declare(strict_types=1);

namespace Tests\Unit\Mailables\Shop;

use PHPUnit\Framework\Attributes\Test;
use App\Infrastructure\MjmlMessage;
use App\Mailables\Shop\OrderCancelledMailable;
use App\Models\Shop\ShopOrder;
use Tests\TestCase;

class OrderCancelledMailableTest extends TestCase
{
    #[Test]
    public function itReturnsAnMjmlMessageInstance(): void
    {
        $this->assertInstanceOf(
            MjmlMessage::class,
            OrderCancelledMailable::make(new ShopOrder(), 'foo'),
        );
    }

    #[Test]
    public function itHasTheSubjectSet(): void
    {
        $mailable = OrderCancelledMailable::make(new ShopOrder(), 'foo');

        $this->assertEquals('Your Coeliac Sanctuary order has been cancelled', $mailable->subject);
    }

    #[Test]
    public function itHasTheCorrectView(): void
    {
        $mailable = OrderCancelledMailable::make(new ShopOrder(), 'foo');

        $this->assertEquals('mailables.mjml.shop.order-cancelled', $mailable->mjml);
    }

    #[Test]
    public function itHasTheCorrectData(): void
    {
        $order = $this->build(ShopOrder::class)->asPaid()->create();

        $data = [
            'order' => fn ($assertionOrder) => $this->assertTrue($order->is($assertionOrder)),
            'notifiable' => fn ($customer) => $this->assertTrue($order->customer->is($customer)),
            'reason' => fn ($reason) => $this->assertEquals('to let you know your Coeliac Sanctuary order has been cancelled.', $reason),
        ];

        $mailable = OrderCancelledMailable::make($order, 'foo');
        $emailData = $mailable->data();

        foreach ($data as $key => $closure) {
            $this->assertArrayHasKey($key, $emailData);
            $closure($emailData[$key]);
        }
    }
}
