<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Shop;

use PHPUnit\Framework\Attributes\Test;
use App\Models\Shop\ShopProduct;
use App\Models\Shop\ShopProductPrice;
use Tests\TestCase;

class ShopProductPriceTest extends TestCase
{
    #[Test]
    public function itBelongsToAProduct(): void
    {
        $price = $this->create(ShopProductPrice::class);

        $this->assertInstanceOf(ShopProduct::class, $price->product()->withoutGlobalScopes()->first());
    }
}
