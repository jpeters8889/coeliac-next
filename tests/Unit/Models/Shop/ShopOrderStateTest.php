<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Shop;

use App\Enums\Shop\OrderState;
use App\Models\Shop\ShopOrder;
use App\Models\Shop\ShopOrderState;
use Database\Seeders\ShopScaffoldingSeeder;
use Illuminate\Support\Collection;
use Tests\TestCase;

class ShopOrderStateTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(ShopScaffoldingSeeder::class);
    }

    /** @test */
    public function itHasOrders(): void
    {
        $this->build(ShopOrder::class)
            ->count(5)
            ->asCompleted()
            ->create();

        $state = ShopOrderState::find(OrderState::COMPLETE);

        $this->assertInstanceOf(Collection::class, $state->orders);
    }
}
