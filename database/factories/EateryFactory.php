<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\EatingOut\Eatery;

class EateryFactory extends Factory
{
    protected $model = Eatery::class;

    public function definition()
    {
        return [
            'name' => $this->faker->title,
            'slug' => $this->faker->slug,
            'town_id' => 1,
            'county_id' => 1,
            'country_id' => 1,
            'type_id' => 1,
            'venue_type_id' => 1,
            'cuisine_id' => 1,
            'info' => $this->faker->sentence,
            'address' => str_replace(', ', '<br />', $this->faker->address),
            'phone' => $this->faker->phoneNumber,
            'website' => $this->faker->url,
            'lat' => $this->faker->latitude,
            'lng' => $this->faker->longitude,
            'live' => true,
        ];
    }

    public function notLive()
    {
        return $this->state(fn () => ['live' => false]);
    }

    public function withOutSlug()
    {
        return $this->state(fn () => ['slug' => null]);
    }
}
