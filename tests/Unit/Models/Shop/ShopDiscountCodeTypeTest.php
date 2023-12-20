<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Shop;

use App\Models\Shop\ShopDiscountCode;
use App\Models\Shop\ShopDiscountCodeType;
use Database\Seeders\ShopScaffoldingSeeder;
use Tests\TestCase;

class ShopDiscountCodeTypeTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(ShopScaffoldingSeeder::class);
    }

    /** @test */
    public function itHasACodesRelationship(): void
    {
        $type = ShopDiscountCodeType::query()->first();

        $this->build(ShopDiscountCode::class)
            ->count(5)
            ->state([
                'type_id' => $type->id,
            ])
            ->create();

        $this->assertCount(5, $type->refresh()->codes);
    }
}
