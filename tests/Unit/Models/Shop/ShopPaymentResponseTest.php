<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Shop;

use PHPUnit\Framework\Attributes\Test;
use App\Models\Shop\ShopPayment;
use App\Models\Shop\ShopPaymentResponse;
use Tests\TestCase;

class ShopPaymentResponseTest extends TestCase
{
    #[Test]
    public function itHasAPayment(): void
    {
        $payment = $this->create(ShopPayment::class);

        $paymentResponse = $this->build(ShopPaymentResponse::class)
            ->forPayment($payment)
            ->create();

        $this->assertInstanceOf(ShopPayment::class, $paymentResponse->payment);
    }
}
