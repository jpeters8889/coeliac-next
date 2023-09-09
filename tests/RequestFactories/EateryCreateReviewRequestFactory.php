<?php

declare(strict_types=1);

namespace Tests\RequestFactories;

use Worksome\RequestFactories\RequestFactory;

class EateryCreateReviewRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return [
            'method' => 'website',
            'rating' => $this->faker->numberBetween(1, 5),
        ];
    }

    public function fullReview(): self
    {
        return $this->state([
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'food_rating' => $this->faker->randomElement(['poor', 'good', 'excellent']),
            'service_rating' => $this->faker->randomElement(['poor', 'good', 'excellent']),
            'how_expensive' => $this->faker->numberBetween(1, 5),
            'review' => $this->faker->paragraph,
        ]);
    }

    public function forBranch(): self
    {
        return $this->state([
            'branch_name' => $this->faker->city,
        ]);
    }
}
