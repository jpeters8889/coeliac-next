<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Shop\PaymentType;
use App\Models\Shop\ShopOrder;
use App\Models\Shop\ShopPayment;

class ShopPaymentFactory extends Factory
{
    protected $model = ShopPayment::class;

    public function definition()
    {
        return [
            'order_id' => Factory::factoryForModel(ShopOrder::class),
            'subtotal' => 100,
            'discount' => 0,
            'postage' => 100,
            'total' => 200,
            'payment_type_id' => PaymentType::STRIPE->value,
        ];
    }

    public function forOrder(ShopOrder $order): self
    {
        return $this->state(fn () => [
            'order_id' => $order->id,
        ]);
    }
}
