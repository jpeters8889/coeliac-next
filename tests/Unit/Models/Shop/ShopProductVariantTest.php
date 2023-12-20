<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Shop;

use App\Models\Shop\ShopProduct;
use App\Models\Shop\ShopProductVariant;
use Tests\TestCase;

class ShopProductVariantTest extends TestCase
{
    /** @test */
    public function itHasALiveScope(): void
    {
        $this->assertNotEmpty(ShopProductVariant::query()->toBase()->wheres);
    }

    /** @test */
    public function itBelongsToAProduct(): void
    {
        $variant = $this->create(ShopProductVariant::class);

        $this->assertInstanceOf(ShopProduct::class, $variant->product);
    }
}
