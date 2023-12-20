<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Shop;

use App\Models\Shop\ShopPayment;
use App\Models\Shop\ShopPaymentType;
use Database\Seeders\ShopScaffoldingSeeder;
use Illuminate\Support\Collection;
use Tests\TestCase;

class ShopPaymentTypeTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(ShopScaffoldingSeeder::class);
    }

    /** @test */
    public function itHasAPayment(): void
    {
        $type = ShopPaymentType::query()->first();

        $this->create(ShopPayment::class);

        $this->assertInstanceOf(Collection::class, $type->payment);
    }
}
