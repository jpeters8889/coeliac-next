<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Shop;

use PHPUnit\Framework\Attributes\Test;
use App\Models\Shop\ShopOrder;
use App\Models\Shop\ShopOrderReview;
use App\Models\Shop\ShopOrderReviewInvitation;
use App\Models\Shop\ShopOrderReviewItem;
use Illuminate\Support\Collection;
use Tests\TestCase;

class ShopOrderReviewTest extends TestCase
{
    #[Test]
    public function itHasAnInvitation(): void
    {
        $invitation = $this->create(ShopOrderReviewInvitation::class);

        $review = $this->build(ShopOrderReview::class)
            ->fromInvitation($invitation)
            ->create();

        $this->assertInstanceOf(ShopOrderReviewInvitation::class, $review->refresh()->invitation);
        $this->assertTrue($review->invitation->is($invitation));
    }

    #[Test]
    public function itHasAnOrder(): void
    {
        $order = $this->create(ShopOrder::class);

        $review = $this->build(ShopOrderReview::class)
            ->forOrder($order)
            ->create();

        $this->assertInstanceOf(ShopOrder::class, $review->refresh()->order);
        $this->assertTrue($review->order->is($order));
    }

    #[Test]
    public function itHasReviewedProducts(): void
    {
        $review = $this->create(ShopOrderReview::class);

        $this->build(ShopOrderReviewItem::class)
            ->count(5)
            ->forReview($review)
            ->create();

        $this->assertInstanceOf(Collection::class, $review->refresh()->products);
    }
}
