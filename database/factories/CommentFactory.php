<?php

namespace Database\Factories;

use App\Modules\Shared\Comments\HasComments;
use App\Modules\Shared\Models\Comment;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'comment' => $this->faker->paragraph,
        ];
    }

    public function on(HasComments $commentable)
    {
        return $this->state(fn (array $attributes) => [
            'commentable_type' => $commentable::class,
            'commentable_id' => $commentable->id,
        ]);
    }
}
