<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Shop;

use PHPUnit\Framework\Attributes\Test;
use App\Models\Shop\ShopPostageCountryArea;
use App\Models\Shop\ShopPostagePrice;
use App\Models\Shop\ShopShippingMethod;
use Database\Seeders\ShopScaffoldingSeeder;
use Tests\TestCase;

class ShopPostagePriceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(ShopScaffoldingSeeder::class);
    }

    #[Test]
    public function itBelongsToAPostageArea(): void
    {
        $postagePrice = $this->create(ShopPostagePrice::class);

        $this->assertInstanceOf(ShopPostageCountryArea::class, $postagePrice->area);
    }

    #[Test]
    public function itBelongsToAShippingMethod(): void
    {
        $postagePrice = $this->create(ShopPostagePrice::class);

        $this->assertInstanceOf(ShopShippingMethod::class, $postagePrice->shippingMethod);
    }
}
