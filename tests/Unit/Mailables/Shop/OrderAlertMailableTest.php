<?php

declare(strict_types=1);

namespace Tests\Unit\Mailables\Shop;

use App\Infrastructure\MjmlMessage;
use App\Mailables\Shop\OrderAlertMailable;
use App\Models\Shop\ShopOrder;
use Tests\TestCase;

class OrderAlertMailableTest extends TestCase
{
    /** @test */
    public function itReturnsAnMjmlMessageInstance(): void
    {
        $this->assertInstanceOf(
            MjmlMessage::class,
            OrderAlertMailable::make(new ShopOrder(), 'foo'),
        );
    }

    /** @test */
    public function itHasTheSubjectSet(): void
    {
        $mailable = OrderAlertMailable::make(new ShopOrder(), 'foo');

        $this->assertEquals('Coeliac Sanctuary - New Order', $mailable->subject);
    }

    /** @test */
    public function itHasTheCorrectView(): void
    {
        $mailable = OrderAlertMailable::make(new ShopOrder(), 'foo');

        $this->assertEquals('mailables.mjml.shop.order-alert', $mailable->mjml);
    }

    /** @test */
    public function itHasTheCorrectData(): void
    {
        $order = $this->build(ShopOrder::class)->asPaid()->create();

        $data = [
            'order' => fn ($assertionOrder) => $this->assertTrue($order->is($assertionOrder)),
            'notifiable' => fn ($customer) => $this->assertTrue($order->customer->is($customer)),
        ];

        $mailable = OrderAlertMailable::make($order, 'foo');
        $emailData = $mailable->data();

        foreach ($data as $key => $closure) {
            $this->assertArrayHasKey($key, $emailData);
            $closure($emailData[$key]);
        }
    }
}
