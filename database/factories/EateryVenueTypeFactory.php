<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Modules\EatingOut\Models\EateryVenueType;

class EateryVenueTypeFactory extends Factory
{
    protected $model = EateryVenueType::class;

    public function definition()
    {
        return [
            'venue_type' => $this->faker->word,
            'type_id' => 1,
        ];
    }
}
