<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\UserAddressType;
use App\Models\User;
use App\Models\UserAddress;

class UserAddressFactory extends Factory
{
    protected $model = UserAddress::class;

    public function definition()
    {
        return [
            'user_id' => Factory::factoryForModel(User::class),
            'type' => $this->faker->randomElement(UserAddressType::cases()),
            'name' => $this->faker->name,
            'line_1' => $this->faker->buildingNumber,
            'line_2' => $this->faker->streetAddress,
            'town' => $this->faker->city,
            'postcode' => $this->faker->postcode,
            'country' => 'England',
        ];
    }

    public function to(User $user): self
    {
        return $this->state(fn () => ['user_id' => $user->id]);
    }

    public function asShipping(): self
    {
        return $this->state(['type' => UserAddressType::SHIPPING]);
    }

    public function asBilling(): self
    {
        return $this->state(['type' => UserAddressType::BILLING]);
    }
}
