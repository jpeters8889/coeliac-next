<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Modules\Recipe\Models\RecipeFeature;

class RecipeFeatureFactory extends Factory
{
    protected $model = RecipeFeature::class;

    public function definition()
    {
        return [
            'feature' => $this->faker->word,
            'slug' => $this->faker->slug,
            'icon' => $this->faker->word,
        ];
    }
}
