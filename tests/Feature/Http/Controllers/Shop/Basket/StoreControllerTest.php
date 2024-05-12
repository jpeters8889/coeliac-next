<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Shop\Basket;

use App\Actions\Shop\AddProductToBasketAction;
use App\Actions\Shop\ResolveBasketAction;
use App\Models\Shop\ShopOrder;
use App\Models\Shop\ShopProduct;
use App\Models\Shop\ShopProductVariant;
use Illuminate\Testing\TestResponse;
use Spatie\TestTime\TestTime;
use Tests\RequestFactories\ShopAddBasketRequestFactory;
use Tests\TestCase;

class StoreControllerTest extends TestCase
{
    protected ShopProduct $product;

    protected ShopProductVariant $variant;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withCategoriesAndProducts(1, 1);

        $this->product = ShopProduct::query()->first();
        $this->variant = $this->product->variants->first();
    }

    /** @test */
    public function itReturnsAValidationErrorWithAnInvalidProductId(): void
    {
        $this->makeRequest(['product_id' => null])->assertSessionHasErrors('product_id');
        $this->makeRequest(['product_id' => 'foo'])->assertSessionHasErrors('product_id');
        $this->makeRequest(['product_id' => true])->assertSessionHasErrors('product_id');
    }

    /** @test */
    public function itReturnsAValidationErrorWithAProductThatDoesntExist(): void
    {
        $this->makeRequest(['product_id' => 123])->assertSessionHasErrors('product_id');
    }

    /** @test */
    public function itReturnsAValidationErrorWithAProductThatHasNoLiveVariants(): void
    {
        $product = $this->create(ShopProduct::class);

        $this->makeRequest(['product_id' => $product->id])->assertSessionHasErrors('product_id');
    }

    /** @test */
    public function itReturnsAValidationErrorWithAnInvalidVariantId(): void
    {
        $this->makeRequest(['variant_id' => null])->assertSessionHasErrors('variant_id');
        $this->makeRequest(['variant_id' => 'foo'])->assertSessionHasErrors('variant_id');
        $this->makeRequest(['variant_id' => true])->assertSessionHasErrors('variant_id');
    }

    /** @test */
    public function itReturnsAValidationErrorWithAVariantThatDoesntExist(): void
    {
        $this->makeRequest(['variant_id' => 123])->assertSessionHasErrors('variant_id');
    }

    /** @test */
    public function itReturnsAValidationErrorWithAVariantForADifferentProduct(): void
    {
        $variant = $this->create(ShopProductVariant::class);

        $this->makeRequest(['variant_id' => $variant->id])->assertSessionHasErrors('variant_id');
    }

    /** @test */
    public function itReturnsAValidationErrorIfTheVariantIsntLive(): void
    {
        $this->variant->update(['live' => false]);

        $this->makeRequest()->assertSessionHasErrors('variant_id');
    }

    /** @test */
    public function itReturnsAValidationErrorWithAnInvalidQuantity(): void
    {
        $this->makeRequest(['quantity' => null])->assertSessionHasErrors('quantity');
        $this->makeRequest(['quantity' => 'foo'])->assertSessionHasErrors('quantity');
        $this->makeRequest(['quantity' => true])->assertSessionHasErrors('quantity');
        $this->makeRequest(['quantity' => -1])->assertSessionHasErrors('quantity');
    }

    /** @test */
    public function itReturnsAValidationErrorIfTheProductVariantDoesntHaveTheRequestedQuantity(): void
    {
        $this->variant->update(['quantity' => 1]);

        $this->makeRequest(['quantity' => 2])->assertSessionHasErrors('quantity');
    }

    /** @test */
    public function itCallsTheResolveBasketAction(): void
    {
        $this->expectAction(ResolveBasketAction::class);

        $this->makeRequest();
    }

    /** @test */
    public function itPassesTheCookieBasketTokenToTheResolveBasketAction(): void
    {
        $order = $this->create(ShopOrder::class);

        $this->expectAction(ResolveBasketAction::class, [$order->token]);
        $this->withCookie('basket_token', $order->token)->makeRequest();

        $this->assertDatabaseCount(ShopOrder::class, 1);
    }

    /** @test */
    public function itReturnsTheBasketTokenInACookie(): void
    {
        $request = $this->makeRequest();

        $order = ShopOrder::query()->first();

        $request->assertCookie('basket_token', $order->token);
    }

    /** @test */
    public function itCallsTheAddProductToBasketAction(): void
    {
        $this->expectAction(AddProductToBasketAction::class, [function ($order, $product, $variant, $quantity) {
            $this->assertTrue($this->product->is($product));
            $this->assertTrue($this->variant->is($variant));
            $this->assertEquals(1, $quantity);

            return true;
        }]);

        $this->makeRequest();
    }

    /** @test */
    public function itUpdatesTheBasketUpdatedAtTime(): void
    {
        TestTime::freeze();
        $order = $this->create(ShopOrder::class);

        TestTime::addMinutes(5);
        $this->withCookie('basket_token', $order->token)->makeRequest();

        $this->assertTrue($order->refresh()->updated_at->isSameSecond(now()));
    }

    /** @test */
    public function itRedirectsBackOnSuccess(): void
    {
        $this->from(route('shop.category', ['category' => $this->product->categories()->first()->slug]))
            ->makeRequest()
            ->assertRedirectToRoute('shop.category', ['category' => $this->product->categories()->first()->slug]);
    }

    protected function makeRequest(array $data = []): TestResponse
    {
        $data = array_merge([
            'product_id' => $this->product->id,
            'variant_id' => $this->variant->id,
        ], $data);

        return $this->put(route('shop.basket.add'), ShopAddBasketRequestFactory::new()->create($data));
    }
}
