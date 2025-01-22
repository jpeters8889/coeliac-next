<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Shop;

use PHPUnit\Framework\Attributes\Test;
use App\Models\Shop\ShopProduct;
use App\Models\Shop\TravelCardSearchTerm;
use Illuminate\Support\Collection;
use Tests\TestCase;

class TravelCardSearchTermTest extends TestCase
{
    #[Test]
    public function itHasSearchTerms(): void
    {
        $products = $this->create(ShopProduct::class, 5);

        $searchTerm = $this->create(TravelCardSearchTerm::class);

        $searchTerm->products()->attach($products);

        $this->assertInstanceOf(Collection::class, $searchTerm->refresh()->products);
    }
}
