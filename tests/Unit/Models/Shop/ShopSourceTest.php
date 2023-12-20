<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Shop;

use App\Models\Shop\ShopOrder;
use App\Models\Shop\ShopSource;
use Illuminate\Support\Collection;
use Tests\TestCase;

class ShopSourceTest extends TestCase
{
    /** @test */
    public function itHasManyOrders(): void
    {
        $source = $this->create(ShopSource::class);

        $orders = $this->create(ShopOrder::class, 5);

        $source->orders()->attach($orders);

        $this->assertInstanceOf(Collection::class, $source->refresh()->orders);
    }
}
