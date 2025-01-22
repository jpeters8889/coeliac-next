<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\Shop;

use PHPUnit\Framework\Attributes\Test;
use App\Actions\Shop\GetProductsForProductIndexAction;
use App\Resources\Shop\ShopProductApiCollection;
use Tests\TestCase;

class IndexControllerTest extends TestCase
{
    #[Test]
    public function itCallsTheGetProductsForProductIndexAction(): void
    {
        $this->expectAction(GetProductsForProductIndexAction::class, return: ShopProductApiCollection::make(collect()));

        $this->get(route('api.shop.products.index'))->assertOk();
    }
}
