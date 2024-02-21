<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Shop;

use App\Models\Shop\ShopOrder;
use App\Models\Shop\ShopPayment;
use App\Models\Shop\ShopPaymentResponse;
use Database\Seeders\ShopScaffoldingSeeder;
use Tests\TestCase;

class ShopPaymentTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(ShopScaffoldingSeeder::class);
    }

    /** @test */
    public function itIsLinkedToAnOrder(): void
    {
        $order = $this->create(ShopOrder::class);

        $payment = $this->build(ShopPayment::class)
            ->forOrder($order)
            ->create();

        $this->assertInstanceOf(ShopOrder::class, $payment->refresh()->order);
    }

    /** @test */
    public function itHasAPaymentResponse(): void
    {
        $payment = $this->create(ShopPayment::class);

        $this->build(ShopPaymentResponse::class)
            ->forPayment($payment)
            ->create();

        $this->assertInstanceOf(ShopPaymentResponse::class, $payment->refresh()->response);
    }
}
