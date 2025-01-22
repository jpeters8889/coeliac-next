<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Shop;

use PHPUnit\Framework\Attributes\Test;
use App\Models\Shop\ShopPostageCountry;
use App\Models\Shop\ShopPostageCountryArea;
use App\Models\Shop\ShopPostagePrice;
use Database\Seeders\ShopScaffoldingSeeder;
use Illuminate\Support\Collection;
use Tests\TestCase;

class ShopPostageCountryAreaTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(ShopScaffoldingSeeder::class);
    }

    #[Test]
    public function itHasManyCountries(): void
    {
        $this->build(ShopPostageCountry::class)->count(5)->create();

        $postageArea = ShopPostageCountryArea::query()->first();

        $this->assertInstanceOf(Collection::class, $postageArea->countries);
    }

    #[Test]
    public function itHasManyPostagePrices(): void
    {
        $this->build(ShopPostagePrice::class)->count(5)->create();

        $postageArea = ShopPostageCountryArea::query()->first();

        $this->assertInstanceOf(Collection::class, $postageArea->postagePrices);
    }
}
