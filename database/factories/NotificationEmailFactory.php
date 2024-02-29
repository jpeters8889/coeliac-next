<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\NotificationEmail;
use App\Models\Shop\ShopCustomer;
use Illuminate\Support\Carbon;

class NotificationEmailFactory extends Factory
{
    protected $model = NotificationEmail::class;

    public function definition(): array
    {
        return [
            'user_id' => static::factoryForModel(ShopCustomer::class),
            'email_address' => $this->faker->unique()->safeEmail(),
            'template' => $this->faker->word(),
            'data' => ['date' => now()->toString()],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
