<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Shop\Basket;

use App\Actions\Shop\AlterItemQuantityAction;
use App\Actions\Shop\VerifyDiscountCodeAction;
use App\Models\Shop\ShopDiscountCode;
use App\Models\Shop\ShopOrder;
use App\Models\Shop\ShopOrderItem;
use App\Models\Shop\ShopPostageCountry;
use App\Models\Shop\ShopProduct;
use App\Models\Shop\ShopProductVariant;
use Illuminate\Encryption\Encrypter;
use Tests\TestCase;

class UpdateControllerTest extends TestCase
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

        $this->item = $this->create(ShopOrderItem::class, [
            'order_id' => $this->order->id,
            'product_id' => $this->product->id,
            'product_variant_id' => $this->variant->id,
            'product_price' => 200,
        ]);
    }

    /** @test */
    public function itRedirectsBackIfAnOrderDoesntExist(): void
    {
        $this
            ->from(route('shop.index'))
            ->patch(route('shop.basket.patch'))
            ->assertRedirectToRoute('shop.index');
    }

    /** @test */
    public function itAllowsValidRequestWithNoData(): void
    {
        $this
            ->withCookie('basket_token', $this->order->token)
            ->from(route('shop.index'))
            ->patch(route('shop.basket.patch'))
            ->assertRedirectToRoute('shop.index');
    }

    /** @test */
    public function itReturnsAValidationErrorIfTheCountryDoesntExist(): void
    {
        $this
            ->withCookie('basket_token', $this->order->token)
            ->patch(route('shop.basket.patch'), [
                'postage_country_id' => 123,
            ])
            ->assertSessionHasErrors('postage_country_id');
    }

    /** @test */
    public function itUpdatesTheCountry(): void
    {
        $country = $this->create(ShopPostageCountry::class, [
            'id' => 5,
        ]);

        $this->assertNotEquals($country->id, $this->order->postage_country_id);

        $this
            ->withCookie('basket_token', $this->order->token)
            ->from(route('shop.index'))
            ->patch(route('shop.basket.patch'), [
                'postage_country_id' => $country->id,
            ])
            ->assertRedirectToRoute('shop.index');

        $this->order->refresh();

        $this->assertEquals($country->id, $this->order->postage_country_id);
    }

    /** @test */
    public function itThrowsAValidationErrorIfActionIsInRequestButNotValidValue(): void
    {
        $this
            ->withCookie('basket_token', $this->order->token)
            ->patch(route('shop.basket.patch'), [
                'action' => true,
            ])
            ->assertSessionHasErrors('action');

        $this
            ->withCookie('basket_token', $this->order->token)
            ->patch(route('shop.basket.patch'), [
                'action' => 123,
            ])
            ->assertSessionHasErrors('action');

        $this
            ->withCookie('basket_token', $this->order->token)
            ->patch(route('shop.basket.patch'), [
                'action' => 'foo',
            ])
            ->assertSessionHasErrors('action');
    }

    /** @test */
    public function itErrorsIfSendingActionWithoutProductIdOrInvalidItemId(): void
    {
        $this
            ->withCookie('basket_token', $this->order->token)
            ->patch(route('shop.basket.patch'), [
                'action' => 'increase',
            ])
            ->assertSessionHasErrors('item_id');

        $this
            ->withCookie('basket_token', $this->order->token)
            ->patch(route('shop.basket.patch'), [
                'action' => 'increase',
                'item_id' => true,
            ])
            ->assertSessionHasErrors('item_id');

        $this
            ->withCookie('basket_token', $this->order->token)
            ->patch(route('shop.basket.patch'), [
                'action' => 'increase',
                'item_id' => 'foo',
            ])
            ->assertSessionHasErrors('item_id');
    }

    /** @test */
    public function itErrorsIfTheItemIsntInTheBasket(): void
    {
        $this
            ->withCookie('basket_token', $this->order->token)
            ->patch(route('shop.basket.patch'), [
                'action' => 'increase',
                'item_id' => 123,
            ])
            ->assertSessionHasErrors(['item_id' => "This product isn't in your basket"]);
    }

    /** @test */
    public function itCallsTheAlterItemQuantityAction(): void
    {
        $this->expectAction(AlterItemQuantityAction::class);

        $this
            ->withoutExceptionHandling()
            ->withCookie('basket_token', $this->order->token)
            ->patch(route('shop.basket.patch'), [
                'action' => 'increase',
                'item_id' => $this->item->id,
            ]);
    }

    /** @test */
    public function itErrorsIfTheDiscountCodeDoesntExist(): void
    {
        $this
            ->withCookie('basket_token', $this->order->token)
            ->patch(route('shop.basket.patch'), [
                'discount' => 'foobar',
            ])
            ->assertSessionHasErrors(['discount' => 'Discount Code not found'])
            ->assertSessionMissing('discountCode');
    }

    /** @test */
    public function itErrorsIfTheDiscountCodeExistsButIsntActiveYet(): void
    {
        $this->build(ShopDiscountCode::class)->startsTomorrow()->create(['code' => 'foobar']);

        $this
            ->withCookie('basket_token', $this->order->token)
            ->patch(route('shop.basket.patch'), [
                'discount' => 'foobar',
            ])
            ->assertSessionHasErrors(['discount' => 'Discount Code not found'])
            ->assertSessionMissing('discountCode');
    }

    /** @test */
    public function itErrorsIfTheDiscountCodeExistsButHasExpired(): void
    {
        $this->build(ShopDiscountCode::class)->expired()->create(['code' => 'foobar']);

        $this
            ->withCookie('basket_token', $this->order->token)
            ->patch(route('shop.basket.patch'), [
                'discount' => 'foobar',
            ])
            ->assertSessionHasErrors(['discount' => 'Discount Code not found'])
            ->assertSessionMissing('discountCode');
    }

    /** @test */
    public function itCallsTheVerifyDiscountCodeAction(): void
    {
        $this->build(ShopDiscountCode::class)->create(['code' => 'foobar']);

        $this->expectAction(VerifyDiscountCodeAction::class);

        $this
            ->withCookie('basket_token', $this->order->token)
            ->patch(route('shop.basket.patch'), [
                'discount' => 'foobar',
            ]);
    }

    /** @test */
    public function itAddsTheDiscountCodeToTheSessionIfItIsValid(): void
    {
        $this->create(ShopDiscountCode::class, [
            'code' => 'foobar',
        ]);

        $this
            ->withCookie('basket_token', $this->order->token)
            ->patch(route('shop.basket.patch'), [
                'discount' => 'foobar',
            ])
            ->assertSessionHas('discountCode');
    }

    /** @test */
    public function itEncryptsTheDiscountCodeInTheSession(): void
    {
        $this->create(ShopDiscountCode::class, [
            'code' => 'foobar',
        ]);

        $this
            ->withCookie('basket_token', $this->order->token)
            ->patch(route('shop.basket.patch'), [
                'discount' => 'foobar',
            ]);

        $discountCode = app('session.store')->get('discountCode');

        $this->assertEquals('foobar', app(Encrypter::class)->decrypt($discountCode));
    }
}