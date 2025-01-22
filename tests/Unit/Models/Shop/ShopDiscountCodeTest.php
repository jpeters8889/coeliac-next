<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Shop;

use PHPUnit\Framework\Attributes\Test;
use App\Models\Shop\ShopDiscountCode;
use App\Models\Shop\ShopDiscountCodesUsed;
use App\Models\Shop\ShopDiscountCodeType;
use App\Models\Shop\ShopOrder;
use Database\Seeders\ShopScaffoldingSeeder;
use Tests\TestCase;

class ShopDiscountCodeTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(ShopScaffoldingSeeder::class);
    }

    #[Test]
    public function itHasADiscountCodeType(): void
    {
        $discountCode = $this->create(ShopDiscountCode::class);

        $this->assertInstanceOf(ShopDiscountCodeType::class, $discountCode->type);
    }

    #[Test]
    public function itHasARelationshipToTheUsedDiscountCodes(): void
    {
        $discountCode = $this->create(ShopDiscountCode::class);

        $this->create(ShopDiscountCodesUsed::class, [
            'discount_id' => $discountCode->id,
        ]);

        $this->assertCount(1, $discountCode->refresh()->used);
    }

    #[Test]
    public function itHasManyOrders(): void
    {
        $orders = $this->build(ShopOrder::class)
            ->asCompleted()
            ->count(5)
            ->create();

        $discountCode = $this->create(ShopDiscountCode::class);

        $orders->each(function (ShopOrder $order) use ($discountCode): void {
            $this->create(ShopDiscountCodesUsed::class, [
                'discount_id' => $discountCode->id,
                'order_id' => $order->id,
            ]);
        });

        $this->assertCount(5, $discountCode->refresh()->orders);
    }
}
