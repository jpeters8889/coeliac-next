<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Shop;

use App\Enums\Shop\OrderState;
use App\Models\Shop\ShopCustomer;
use App\Models\Shop\ShopDiscountCode;
use App\Models\Shop\ShopDiscountCodesUsed;
use App\Models\Shop\ShopOrder;
use App\Models\Shop\ShopOrderItem;
use App\Models\Shop\ShopOrderReview;
use App\Models\Shop\ShopOrderReviewInvitation;
use App\Models\Shop\ShopOrderReviewItem;
use App\Models\Shop\ShopOrderState;
use App\Models\Shop\ShopPayment;
use App\Models\Shop\ShopPostageCountry;
use App\Models\Shop\ShopShippingAddress;
use App\Models\Shop\ShopSource;
use Database\Seeders\ShopScaffoldingSeeder;
use Illuminate\Support\Collection;
use Tests\TestCase;

class ShopOrderTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(ShopScaffoldingSeeder::class);
    }

    /** @test */
    public function itHasADefaultState(): void
    {
        $order = $this->create(ShopOrder::class);

        $this->assertEquals(OrderState::BASKET, $order->state_id);
    }

    /** @test */
    public function itHasADefaultPostageCountry(): void
    {
        $order = $this->create(ShopOrder::class);

        $this->assertEquals(1, $order->postage_country_id);
    }

    /** @test */
    public function itHasADefaultToken(): void
    {
        $order = $this->create(ShopOrder::class, [
            'token' => null,
        ]);

        $this->assertNotNull($order->token);
    }

    /** @test */
    public function itHasAState(): void
    {
        $order = $this->build(ShopOrder::class)
            ->asPaid()
            ->create();

        $this->assertInstanceOf(ShopOrderState::class, $order->state);
    }

    /** @test */
    public function itHasACustomer(): void
    {
        $customer = $this->create(ShopCustomer::class);

        $order = $this->build(ShopOrder::class)
            ->forCustomer($customer)
            ->create();

        $this->assertInstanceOf(ShopCustomer::class, $order->customer);
        $this->assertTrue($order->customer->is($customer));
    }

    /** @test */
    public function itHasAnAddress(): void
    {
        $address = $this->create(ShopShippingAddress::class);

        $order = $this->build(ShopOrder::class)
            ->toAddress($address)
            ->create();

        $this->assertInstanceOf(ShopShippingAddress::class, $order->address);
        $this->assertTrue($order->address->is($address));
    }

    /** @test */
    public function itHasAPaymentRecord(): void
    {
        $order = $this->create(ShopOrder::class);

        $payment = $this->build(ShopPayment::class)
            ->forOrder($order)
            ->create();

        $order->refresh();

        $this->assertInstanceOf(ShopPayment::class, $order->payment);
        $this->assertTrue($order->payment->is($payment));
    }

    /** @test */
    public function itHasItems(): void
    {
        $order = $this->create(ShopOrder::class);

        $this->build(ShopOrderItem::class)
            ->inOrder($order)
            ->count(5)
            ->create();

        $order->refresh();

        $this->assertCount(5, $order->items);
    }

    /** @test */
    public function itHasAPostageCountry(): void
    {
        $order = $this->create(ShopOrder::class, [
            'postage_country_id' => $this->build(ShopPostageCountry::class),
        ]);

        $this->assertInstanceOf(ShopPostageCountry::class, $order->postageCountry);
    }

    /** @test */
    public function itCanHaveADiscountCode(): void
    {
        $order = $this->create(ShopOrder::class);

        $this->build(ShopDiscountCodesUsed::class)
            ->forOrder($order)
            ->create();

        $this->assertInstanceOf(ShopDiscountCode::class, $order->refresh()->discountCode);
    }

    /** @test */
    public function itCanHaveAReviewInvitation(): void
    {
        $order = $this->create(ShopOrder::class);

        $this->build(ShopOrderReviewInvitation::class)
            ->forOrder($order)
            ->create();

        $this->assertInstanceOf(ShopOrderReviewInvitation::class, $order->refresh()->reviewInvitation);
    }

    /** @test */
    public function itHasReviews(): void
    {
        $order = $this->create(ShopOrder::class);

        $this->build(ShopOrderReview::class)
            ->count(5)
            ->forOrder($order)
            ->create();

        $this->assertInstanceOf(Collection::class, $order->refresh()->reviews);
        $this->assertInstanceOf(ShopOrderReview::class, $order->reviews->first());
    }

    /** @test */
    public function itHasReviewedItems(): void
    {
        $order = $this->create(ShopOrder::class);

        $this->build(ShopOrderReviewItem::class)
            ->count(5)
            ->forOrder($order)
            ->create();

        $this->assertInstanceOf(Collection::class, $order->refresh()->reviewedItems);
        $this->assertInstanceOf(ShopOrderReviewItem::class, $order->reviewedItems->first());
    }

    /** @test */
    public function itCanHaveASource(): void
    {
        $order = $this->create(ShopOrder::class);

        $source = $this->create(ShopSource::class);

        $order->sources()->attach($source);

        $this->assertInstanceOf(Collection::class, $order->refresh()->sources);
        $this->assertTrue($order->sources->first()->is($source));
    }
}
