<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Shop\OrderState;
use App\Models\Shop\ShopOrder;
use App\Models\Shop\ShopPostageCountry;
use App\Models\User;
use App\Models\UserAddress;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ShopOrderFactory extends Factory
{
    protected $model = ShopOrder::class;

    public function definition()
    {
        return [
            'state_id' => OrderState::BASKET->value,
            'token' => Str::random(8),
            'postage_country_id' => self::factoryForModel(ShopPostageCountry::class),
            'user_id' => self::factoryForModel(User::class)
                ->has(self::factoryForModel(UserAddress::class)->asShipping(), 'addresses')
                ->create()
                ->id,
            'user_address_id' => 1,
        ];
    }

    public function forUser(User $user)
    {
        return $this->state(fn () => [
            'user_id' => $user->id,
        ]);
    }

    public function toAddress(UserAddress $address)
    {
        return $this->state(fn () => [
            'user_address_id' => $address->id,
        ]);
    }

    public function asBasket()
    {
        return $this->state(fn () => [
            'state_id' => OrderState::BASKET,
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
