<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Modules\EatingOut\Models\EateryCuisine;

class EateryCuisineFactory extends Factory
{
    protected $model = EateryCuisine::class;

    public function definition()
    {
        return [
            'cuisine' => $this->faker->name,
        ];
    }
}
