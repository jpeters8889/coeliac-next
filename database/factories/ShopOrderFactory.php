<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Shop\OrderState;
use App\Models\Shop\ShopCustomer;
use App\Models\Shop\ShopOrder;
use App\Models\Shop\ShopShippingAddress;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ShopOrderFactory extends Factory
{
    protected $model = ShopOrder::class;

    public function definition()
    {
        return [
            'token' => Str::random(8),
        ];
    }

    public function forCustomer(ShopCustomer $customer)
    {
        return $this->state(fn () => [
            'customer_id' => $customer->id,
        ]);
    }

    public function toAddress(ShopShippingAddress $address)
    {
        return $this->state(fn () => [
            'shipping_address_id' => $address->id,
        ]);
    }

    public function asBasket()
    {
        return $this->state(fn () => [
            'state_id' => OrderState::BASKET,
        ]);
    }

    public function asPending()
    {
        return $this->state(fn () => [
            'state_id' => OrderState::PENDING,
            'payment_intent_id' => $this->faker->uuid,
        ]);
    }

    public function asExpired()
    {
        return $this->state(fn () => [
            'state_id' => OrderState::EXPIRED,
        ]);
    }

    public function asPaid()
    {
        return $this->state(fn () => [
            'state_id' => OrderState::PAID,
            'order_key' => random_int(10000000, 99999999),
        ]);
    }

    public function asCompleted()
    {
        return $this->state(fn () => [
            'state_id' => OrderState::COMPLETE,
            'order_key' => random_int(10000000, 99999999),
            'shipped_at' => Carbon::now(),
        ]);
    }
}
