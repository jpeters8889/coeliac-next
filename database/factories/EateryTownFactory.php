<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\EatingOut\EateryTown;
use Illuminate\Support\Str;

class EateryTownFactory extends Factory
{
    protected $model = EateryTown::class;

    public function definition()
    {
        $town = $this->faker->city;

        return [
            'county_id' => 1,
            'town' => $town,
            'slug' => Str::slug($town),
            'legacy' => Str::slug($town),
        ];
    }
}
