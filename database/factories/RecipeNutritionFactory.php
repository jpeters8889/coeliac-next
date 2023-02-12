<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Modules\Recipe\Models\RecipeNutrition;

class RecipeNutritionFactory extends Factory
{
    protected $model = RecipeNutrition::class;

    public function definition()
    {
        return [
            'calories' => $this->faker->randomDigitNotNull,
            'carbs' => $this->faker->randomDigitNotNull,
            'fat' => $this->faker->randomDigitNotNull,
            'protein' => $this->faker->randomDigitNotNull,
            'fibre' => $this->faker->randomDigitNotNull,
            'sugar' => $this->faker->randomDigitNotNull,
        ];
    }
}
