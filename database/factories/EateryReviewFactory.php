<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Modules\EatingOut\Models\Eatery;
use App\Modules\EatingOut\Models\EateryReview;

class EateryReviewFactory extends Factory
{
    protected $model = EateryReview::class;

    public function definition()
    {
        return [
            'rating' => $this->faker->numberBetween(1, 5),
            'ip' => $this->faker->ipv6,
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'how_expensive' => $this->faker->numberBetween(1, 5),
            'body' => $this->faker->paragraph,
            'method' => 'test',
            'approved' => false,
        ];
    }

    public function approved()
    {
        return $this->state(fn (array $attributes) => ['approved' => true]);
    }

    public function on(Eatery $eatery)
    {
        return $this->state(fn (array $attributes) => [
            'wheretoeat_id' => $eatery->id,
        ]);
    }
}
