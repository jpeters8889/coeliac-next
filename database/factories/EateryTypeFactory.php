<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\EatingOut\EateryType;

class EateryTypeFactory extends Factory
{
    protected $model = EateryType::class;

    public function definition()
    {
        return [
            'type' => 'wte',
            'name' => 'Eatery',
        ];
    }
}
