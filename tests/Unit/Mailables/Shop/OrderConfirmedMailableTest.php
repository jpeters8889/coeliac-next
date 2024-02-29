<?php

declare(strict_types=1);

namespace Tests\Unit\Mailables\Shop;

use App\Infrastructure\MjmlMessage;
use App\Mailables\Shop\OrderConfirmedMailable;
use App\Models\Shop\ShopOrder;
use Tests\TestCase;

class OrderConfirmedMailableTest extends TestCase
{
    /** @test */
    public function itReturnsAnMjmlMessageInstance(): void
    {
        $this->assertInstanceOf(
            MjmlMessage::class,
            OrderConfirmedMailable::make(new ShopOrder(), 'foo'),
        );
    }

    /** @test */
    public function itHasTheSubjectSet(): void
    {
        $mailable = OrderConfirmedMailable::make(new ShopOrder(), 'foo');

        $this->assertEquals('Your Coeliac Sanctuary order is confirmed!', $mailable->subject);
    }

    /** @test */
    public function itHasTheCorrectView(): void
    {
        $mailable = OrderConfirmedMailable::make(new ShopOrder(), 'foo');

        $this->assertEquals('mailables.mjml.shop.order-complete', $mailable->mjml);
    }

    /** @test */
    public function itHasTheCorrectData(): void
    {
        $order = $this->build(ShopOrder::class)->asPaid()->create();

        $data = [
            'order' => fn ($assertionOrder) => $this->assertTrue($order->is($assertionOrder)),
            'notifiable' => fn ($customer) => $this->assertTrue($order->customer->is($customer)),
            'reason' => fn ($reason) => $this->assertEquals('as confirmation to an order placed in the Coeliac Sanctuary Shop.', $reason),
        ];

        $mailable = OrderConfirmedMailable::make($order, 'foo');
        $emailData = $mailable->data();

        foreach ($data as $key => $closure) {
            $this->assertArrayHasKey($key, $emailData);
            $closure($emailData[$key]);
        }
    }
}
