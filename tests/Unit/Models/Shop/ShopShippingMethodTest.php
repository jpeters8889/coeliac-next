<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Shop;

use App\Models\Shop\ShopPostagePrice;
use App\Models\Shop\ShopProduct;
use App\Models\Shop\ShopShippingMethod;
use Database\Seeders\ShopScaffoldingSeeder;
use Illuminate\Support\Collection;
use Tests\TestCase;

class ShopShippingMethodTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(ShopScaffoldingSeeder::class);
    }

    /** @test */
    public function itHasManyProducts(): void
    {
        $shippingMethod = ShopShippingMethod::query()->first();

        $this->create(ShopProduct::class);

        $this->assertInstanceOf(Collection::class, $shippingMethod->products);
    }

    /** @test */
    public function itHasManyPostagePrices(): void
    {
        $shippingMethod = ShopShippingMethod::query()->first();

        $this->create(ShopPostagePrice::class);

        $this->assertInstanceOf(Collection::class, $shippingMethod->prices);
    }
}
