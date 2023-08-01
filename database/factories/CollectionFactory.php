<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Collections\Collection;
use Carbon\Carbon;

class CollectionFactory extends Factory
{
    protected $model = Collection::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'slug' => $this->faker->slug,
            'meta_keywords' => implode(',', $this->faker->words(5)),
            'meta_description' => $description = $this->faker->paragraph,
            'long_description' => $description,
            'body' => $this->faker->paragraphs(3, true),
            'live' => true,
            'draft' => false,
            'publish_at' => Carbon::now(),
        ];
    }
}
