<?php

declare(strict_types=1);

namespace Feature\Http\Controllers\Shop;

use App\Actions\Shop\CalculateOrderPostageAction;
use App\Actions\Shop\GetOrderItemsAction;
use App\Actions\Shop\ResolveBasketAction;
use App\Enums\Shop\PostageArea;
use App\Models\Shop\ShopOrder;
use App\Models\Shop\ShopOrderItem;
use App\Models\Shop\ShopPostagePrice;
use App\Models\Shop\ShopProduct;
use App\Models\Shop\ShopProductVariant;
use App\Resources\Shop\ShopOrderItemResource;
use App\Support\Helpers;
use Database\Seeders\ShopScaffoldingSeeder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Inertia\Testing\AssertableInertia as Assert;
use Money\Money;
use Spatie\TestTime\TestTime;
use Tests\TestCase;

class ShopCheckoutControllerTest extends TestCase
{
    protected ShopOrder $order;

    protected ShopOrderItem $item;

    protected ShopProduct $product;

    protected ShopProductVariant $variant;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(ShopScaffoldingSeeder::class);
        $this->withCategoriesAndProducts(1, 1);

        $this->order = ShopOrder::query()->create([
            'postage_country_id' => 1,
        ]);
        $this->product = ShopProduct::query()->first();
        $this->variant = $this->product->variants->first();

        $this->item = $this->create(ShopOrderItem::class, [
            'order_id' => $this->order->id,
            'product_id' => $this->product->id,
            'product_variant_id' => $this->variant->id,
            'product_price' => 200,
        ]);

        $this->create(ShopPostagePrice::class, [
            'postage_country_area_id' => PostageArea::UK->value,
            'shipping_method_id' => $this->product->shipping_method_id,
            'max_weight' => 500,
            'price' => 100,
        ]);
    }

    /** @test */
    public function itReturnsOk(): void
    {
        $this->get(route('shop.basket.checkout'))->assertOk();
    }

    /** @test */
    public function itReturnsTheInertiaCheckoutView(): void
    {
        $this->get(route('shop.basket.checkout'))
            ->assertInertia(fn (Assert $page) => $page->component('Shop/Checkout'));
    }

    /** @test */
    public function itCallsTheResolveBasketAction(): void
    {
        $this->expectAction(ResolveBasketAction::class);

        $this->get(route('shop.basket.checkout'));
    }

    /** @test */
    public function itPassesHasBasketFalseAsAPropIfNoBasket(): void
    {
        $this->get(route('shop.basket.checkout'))
            ->assertInertia(fn (Assert $page) => $page->where('has_basket', false));
    }

    /** @test */
    public function itPassesHasBasketFalseAsAPropIfABasketExists(): void
    {
        $this
            ->withCookie('basket_token', $this->order->token)
            ->get(route('shop.basket.checkout'))
            ->assertInertia(fn (Assert $page) => $page->where('has_basket', true)->etc());
    }

    /** @test */
    public function itCallsTheGetOrderItemsActonIfABasketExists(): void
    {
        $this->markTestSkipped();
        $this->expectAction(GetOrderItemsAction::class);

        $this
            ->withCookie('basket_token', $this->order->token)
            ->get(route('shop.basket.checkout'));
    }

    /** @test */
    public function itUpdatesTheBasketTimestamp(): void
    {
        TestTime::freeze();
        TestTime::addMinutes(30);

        $this->assertFalse($this->order->refresh()->updated_at->isSameSecond(now()));

        $this
            ->withCookie('basket_token', $this->order->token)
            ->get(route('shop.basket.checkout'));

        $this->assertTrue($this->order->refresh()->updated_at->isSameSecond(now()));
    }

    /** @test */
    public function itPassesTheBasketItemsToTheComponent(): void
    {
        /** @var AnonymousResourceCollection $items */
        $items = $this->callAction(GetOrderItemsAction::class, $this->order);

        $this
            ->withCookie('basket_token', $this->order->token)
            ->get(route('shop.basket.checkout'))
            ->assertInertia(
                fn (Assert $page) => $page
                    ->has(
                        'basket',
                        fn (Assert $page) => $page
                            ->has('items', $items->count())
                            ->where('items', $items->toArray(request()))
                            ->etc()
                    )
                    ->etc()
            );
    }

    /** @test */
    public function itPassesTheSubtotalToTheComponent(): void
    {
        /** @var AnonymousResourceCollection $items */
        $items = $this->callAction(GetOrderItemsAction::class, $this->order);

        $subtotal = $items->collection->map(fn (ShopOrderItemResource $item) => $item->product_price * $item->quantity)->sum();

        $this
            ->withCookie('basket_token', $this->order->token)
            ->get(route('shop.basket.checkout'))
            ->assertInertia(
                fn (Assert $page) => $page
                    ->has(
                        'basket',
                        fn (Assert $page) => $page
                            ->where('subtotal', Helpers::formatMoney(Money::GBP($subtotal)))
                            ->etc()
                    )
                    ->etc()
            );
    }

    /** @test */
    public function itCallsTheCalculateOrderPostageAction(): void
    {
        $this->expectAction(CalculateOrderPostageAction::class);

        $this
            ->withCookie('basket_token', $this->order->token)
            ->get(route('shop.basket.checkout'));
    }

    /** @test */
    public function itCalculatesThePostagePriceAndPassesItToTheComponent(): void
    {
        $this
            ->withCookie('basket_token', $this->order->token)
            ->get(route('shop.basket.checkout'))
            ->assertInertia(
                fn (Assert $page) => $page
                    ->has(
                        'basket',
                        fn (Assert $page) => $page
                            ->where('postage', '£1.00')
                            ->etc()
                    )
                    ->etc()
            );
    }

    /** @test */
    public function itPassesTheTotalToTheComponent(): void
    {
        $this
            ->withCookie('basket_token', $this->order->token)
            ->get(route('shop.basket.checkout'))
            ->assertInertia(
                fn (Assert $page) => $page
                    ->has(
                        'basket',
                        fn (Assert $page) => $page
                            ->where('total', '£3.00')
                            ->etc()
                    )
                    ->etc()
            );
    }

    /** @test */
    public function itPassesTheShippableCountriesToTheComponent(): void
    {
        $this
            ->withCookie('basket_token', $this->order->token)
            ->get(route('shop.basket.checkout'))
            ->assertInertia(
                fn (Assert $page) => $page
                    ->has('countries')
                    ->etc()
            );
    }

    /** @test */
    public function itPassesTheSelectedCountryId(): void
    {
        $this
            ->withCookie('basket_token', $this->order->token)
            ->get(route('shop.basket.checkout'))
            ->assertInertia(
                fn (Assert $page) => $page
                    ->has(
                        'basket',
                        fn (Assert $page) => $page
                            ->where('selected_country', 1)
                            ->etc()
                    )
                    ->etc()
            );
    }

    /** @test */
    public function itPassesTheDeliveryTimescale(): void
    {
        $this
            ->withCookie('basket_token', $this->order->token)
            ->get(route('shop.basket.checkout'))
            ->assertInertia(
                fn (Assert $page) => $page
                    ->has(
                        'basket',
                        fn (Assert $page) => $page
                            ->where('delivery_timescale', '1 - 2')
                            ->etc()
                    )
                    ->etc()
            );
    }
}
