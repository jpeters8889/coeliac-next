<?php

namespace Database\Factories;

use App\Modules\Blog\Models\BlogTag;

class BlogTagFactory extends Factory
{
    protected $model = BlogTag::class;

    public function definition()
    {
        return [
            'tag' => $this->faker->word,
            'slug' => $this->faker->word,
        ];
    }
}
