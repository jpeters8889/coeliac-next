<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Shop;

use App\Models\Shop\ShopDiscountCode;
use App\Models\Shop\ShopDiscountCodesUsed;
use App\Models\Shop\ShopOrder;
use Database\Seeders\ShopScaffoldingSeeder;
use Tests\TestCase;

class ShopDiscountCodesUsedTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(ShopScaffoldingSeeder::class);
    }

    /** @test */
    public function itHasADiscountCode(): void
    {
        $discountCodeType = $this->create(ShopDiscountCodesUsed::class);

        $this->assertInstanceOf(ShopDiscountCode::class, $discountCodeType->code);
    }

    /** @test */
    public function itHasAnOrder(): void
    {
        $discountCodeType = $this->create(ShopDiscountCodesUsed::class);

        $this->assertInstanceOf(ShopOrder::class, $discountCodeType->order);
    }
}
