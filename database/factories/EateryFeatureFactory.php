<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Modules\EatingOut\Models\EateryFeature;

class EateryFeatureFactory extends Factory
{
    protected $model = EateryFeature::class;

    public function definition()
    {
        return [
            'icon' => $this->faker->word,
            'feature' => $this->faker->word,
        ];
    }
}
