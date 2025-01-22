<?php

declare(strict_types=1);

namespace Tests\Unit\Console\Commands;

use PHPUnit\Framework\Attributes\Test;
use App\Models\Shop\ShopProductPrice;
use Spatie\TestTime\TestTime;
use Tests\TestCase;

class CleanUpOldProductPricesCommandTest extends TestCase
{
    #[Test]
    public function itDoesntDeleteProductPricesWithoutAnEndAt(): void
    {
        $price = $this->create(ShopProductPrice::class);

        $this->assertNull($price->end_at);

        $this->artisan('coeliac:clean-up-product-prices');

        $this->assertModelExists($price);
    }

    #[Test]
    public function itDoesntDeleteProductPricesWithAnEndAtInTheFuture(): void
    {
        $price = $this->create(ShopProductPrice::class, [
            'end_at' => now()->addDay(),
        ]);

        $this->assertNotNull($price->end_at);

        $this->artisan('coeliac:clean-up-product-prices');

        $this->assertModelExists($price);
    }

    #[Test]
    public function itDeletesProductPricesThatHaveEnded(): void
    {
        TestTime::freeze();

        $price = $this->create(ShopProductPrice::class, [
            'end_at' => now(),
        ]);

        TestTime::addMinute();

        $this->artisan('coeliac:clean-up-product-prices');

        $this->assertModelMissing($price);
    }
}
