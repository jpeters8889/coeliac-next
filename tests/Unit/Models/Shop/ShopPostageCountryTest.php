<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Shop;

use PHPUnit\Framework\Attributes\Test;
use App\Models\Shop\ShopOrder;
use App\Models\Shop\ShopPostageCountry;
use App\Models\Shop\ShopPostageCountryArea;
use Database\Seeders\ShopScaffoldingSeeder;
use Illuminate\Support\Collection;
use Tests\TestCase;

class ShopPostageCountryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(ShopScaffoldingSeeder::class);
    }

    #[Test]
    public function itBelongsToAPostageArea(): void
    {
        $country = $this->create(ShopPostageCountry::class);

        $this->assertInstanceOf(ShopPostageCountryArea::class, $country->area);
    }

    #[Test]
    public function itHasManyOrders(): void
    {
        $country = $this->create(ShopPostageCountry::class);

        $this->build(ShopOrder::class)->count(5)->create();

        $this->assertInstanceOf(Collection::class, $country->refresh()->orders);
    }
}
