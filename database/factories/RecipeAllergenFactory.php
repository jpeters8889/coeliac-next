<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Modules\Recipe\Models\RecipeAllergen;

class RecipeAllergenFactory extends Factory
{
    protected $model = RecipeAllergen::class;

    public function definition()
    {
        return [
            'allergen' => $this->faker->word,
        ];
    }
}
