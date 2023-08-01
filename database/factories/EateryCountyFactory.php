<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\EatingOut\EateryCounty;
use Illuminate\Support\Str;

class EateryCountyFactory extends Factory
{
    protected $model = EateryCounty::class;

    public function definition()
    {
        $county = $this->faker->state;

        return [
            'country_id' => 1,
            'county' => $county,
            'slug' => Str::slug($county),
            'legacy' => ucfirst(Str::slug($county)),
        ];
    }
}
