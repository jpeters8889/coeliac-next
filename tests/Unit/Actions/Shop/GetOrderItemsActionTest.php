<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Shop;

use App\Actions\Shop\AddProductToBasketAction;
use App\Actions\Shop\GetOrderItemsAction;
use App\Models\Shop\ShopOrder;
use App\Models\Shop\ShopProduct;
use App\Models\Shop\ShopProductVariant;
use App\Resources\Shop\ShopOrderItemResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Tests\TestCase;

class GetOrderItemsActionTest extends TestCase
{
    protected ShopOrder $order;

    protected ShopProduct $product;

    protected ShopProductVariant $variant;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withCategoriesAndProducts(1, 1);

        $this->order = ShopOrder::query()->create();
        $this->product = ShopProduct::query()->first();
        $this->variant = $this->product->variants->first();

        app(AddProductToBasketAction::class)->handle($this->order, $this->product, $this->variant, 1);
    }

    /** @test */
    public function itReturnsACollectionOfOrderItems(): void
    {
        $items = app(GetOrderItemsAction::class)->handle($this->order);

        $this->assertInstanceOf(AnonymousResourceCollection::class, $items);
        $this->assertInstanceOf(ShopOrderItemResource::class, $items->first());
    }
}
