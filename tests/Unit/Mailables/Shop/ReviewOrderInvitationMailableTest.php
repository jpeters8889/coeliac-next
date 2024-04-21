<?php

declare(strict_types=1);

namespace Tests\Unit\Mailables\Shop;

use App\Infrastructure\MjmlMessage;
use App\Mailables\Shop\ReviewOrderInvitationMailable;
use App\Models\Shop\ShopOrder;
use Tests\TestCase;

class ReviewOrderInvitationMailableTest extends TestCase
{
    protected ShopOrder $order;

    public function setUp(): void
    {
        parent::setUp();

        $this->order = $this->build(ShopOrder::class)
            ->asPaid()
            ->create();

        $this->order->reviewInvitation()->create();
    }

    /** @test */
    public function itReturnsAnMjmlMessageInstance(): void
    {
        $this->assertInstanceOf(
            MjmlMessage::class,
            ReviewOrderInvitationMailable::make($this->order, 'foo', 'bar'),
        );
    }

    /** @test */
    public function itHasTheSubjectSet(): void
    {
        $mailable = ReviewOrderInvitationMailable::make($this->order, 'foo', 'bar');

        $this->assertEquals('Review your Coeliac Sanctuary Order!', $mailable->subject);
    }

    /** @test */
    public function itHasTheCorrectView(): void
    {
        $mailable = ReviewOrderInvitationMailable::make($this->order, 'foo', 'bar');

        $this->assertEquals('mailables.mjml.shop.review-invitation', $mailable->mjml);
    }

    /** @test */
    public function itHasTheCorrectData(): void
    {
        $data = [
            'order' => fn ($assertionOrder) => $this->assertTrue($this->order->is($assertionOrder)),
            'notifiable' => fn ($customer) => $this->assertTrue($this->order->customer->is($customer)),
            'reason' => fn ($reason) => $this->assertEquals('to invite you to leave feedback on your recent purchase.', $reason),
        ];

        $mailable = ReviewOrderInvitationMailable::make($this->order, 'foo', 'bar');
        $emailData = $mailable->data();

        foreach ($data as $key => $closure) {
            $this->assertArrayHasKey($key, $emailData);
            $closure($emailData[$key]);
        }
    }
}
