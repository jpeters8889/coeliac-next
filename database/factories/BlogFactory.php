<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Modules\Blog\Models\Blog;
use Illuminate\Support\Str;

class BlogFactory extends Factory
{
    protected $model = Blog::class;

    public function definition()
    {
        $title = $this->faker->sentence;

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->paragraph,
            'body' => $this->faker->paragraph,
            'live' => true,
            'meta_tags' => implode(',', $this->faker->words(10)),
            'meta_description' => $this->faker->paragraph,
        ];
    }

    public function notLive()
    {
        return $this->state(fn () => ['live' => false]);
    }
}
