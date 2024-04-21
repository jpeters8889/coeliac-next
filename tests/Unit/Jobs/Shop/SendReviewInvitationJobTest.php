<?php

declare(strict_types=1);

namespace Tests\Unit\Jobs\Shop;

use App\Jobs\Shop\SendReviewInvitationJob;
use App\Models\Shop\ShopOrder;
use App\Models\Shop\ShopOrderReviewInvitation;
use App\Notifications\Shop\ReviewOrderInvitationNotification;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SendReviewInvitationJobTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Notification::fake();
    }

    /** @test */
    public function itCreatesAnInvitationRowLinkedToTheOrder(): void
    {
        /** @var ShopOrder $order */
        $order = $this->build(ShopOrder::class)->asPaid()->create();

        $this->assertDatabaseEmpty(ShopOrderReviewInvitation::class);
        $this->assertNull($order->reviewInvitation);

        (new SendReviewInvitationJob($order, 'foo'))->handle();

        $this->assertDatabaseCount(ShopOrderReviewInvitation::class, 1);
        $this->assertNotNull($order->refresh()->reviewInvitation);
    }

    /** @test */
    public function itNotifiesTheCustomerUsingTheReviewOrderNotification(): void
    {
        /** @var ShopOrder $order */
        $order = $this->build(ShopOrder::class)->asPaid()->create();

        (new SendReviewInvitationJob($order, 'foo'))->handle();

        Notification::assertSentTo($order->customer, ReviewOrderInvitationNotification::class);
    }

    /** @test */
    public function itUpdatesTheInvitationToMarkItAsSent(): void
    {
        /** @var ShopOrder $order */
        $order = $this->build(ShopOrder::class)->asPaid()->create();

        (new SendReviewInvitationJob($order, 'foo'))->handle();

        $this->assertTrue($order->reviewInvitation->sent);
    }
}
