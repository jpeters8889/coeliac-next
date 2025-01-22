<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\Shop;

use PHPUnit\Framework\Attributes\Test;
use App\Models\Shop\ShopProduct;
use Tests\TestCase;

class GetControllerTest extends TestCase
{
    #[Test]
    public function itErrorsIfAProductCantBeFound(): void
    {
        $this->get(route('api.shop.products.show', 'foo'))->assertNotFound();
    }

    #[Test]
    public function itReturnsTheProduct(): void
    {
        $this->withCategoriesAndProducts(1, 1);

        $product = ShopProduct::query()->first();

        $this->get(route('api.shop.products.show', $product))->assertOk();
    }
}
