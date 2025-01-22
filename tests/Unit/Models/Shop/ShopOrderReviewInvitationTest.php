<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Shop;

use PHPUnit\Framework\Attributes\Test;
use App\Models\Shop\ShopOrder;
use App\Models\Shop\ShopOrderReview;
use App\Models\Shop\ShopOrderReviewInvitation;
use Illuminate\Support\Str;
use Tests\TestCase;

class ShopOrderReviewInvitationTest extends TestCase
{
    #[Test]
    public function itHasAUuidKey(): void
    {
        $invitation = $this->create(ShopOrderReviewInvitation::class);

        $this->assertTrue(Str::isUuid($invitation->id));
    }

    #[Test]
    public function itHasAnOrder(): void
    {
        $order = $this->create(ShopOrder::class);

        $invitation = $this->build(ShopOrderReviewInvitation::class)
            ->forOrder($order)
            ->create();

        $this->assertInstanceOf(ShopOrder::class, $invitation->refresh()->order);
    }

    #[Test]
    public function itHasAReview(): void
    {
        $invitation = $this->create(ShopOrderReviewInvitation::class);

        $this->build(ShopOrderReview::class)
            ->fromInvitation($invitation)
            ->create();

        $this->assertInstanceOf(ShopOrderReview::class, $invitation->refresh()->review);
    }
}
