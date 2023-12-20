<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Shop;

use App\Models\Shop\ShopOrder;
use App\Models\Shop\ShopOrderReview;
use App\Models\Shop\ShopOrderReviewItem;
use App\Models\Shop\ShopProduct;
use Tests\TestCase;

class ShopOrderReviewItemTest extends TestCase
{
    /** @test */
    public function itBelongsToAProduct(): void
    {
        $product = $this->create(ShopProduct::class);

        $reviewItem = $this->build(ShopOrderReviewItem::class)
            ->forProduct($product)
            ->create();

        $this->assertInstanceOf(ShopProduct::class, $reviewItem->product()->withoutGlobalScopes()->first());
    }

    /** @test */
    public function itCanGetItsParentReview(): void
    {
        $review = $this->create(ShopOrderReview::class);

        $item = $this->build(ShopOrderReviewItem::class)
            ->forReview($review)
            ->create();

        $this->assertInstanceOf(ShopOrderReview::class, $item->parent);
    }

    /** @test */
    public function itCanGetItsOrder(): void
    {
        $order = $this->create(ShopOrder::class);

        $item = $this->build(ShopOrderReviewItem::class)
            ->forOrder($order)
            ->create();

        $this->assertInstanceOf(ShopOrder::class, $item->order);
    }
}
