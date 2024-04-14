<?php

declare(strict_types=1);

namespace App\Concerns\Comments;

use App\Models\Comments\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @mixin Model
 * @property string $title
 */
trait Commentable
{
    /** @return MorphMany<Comment> */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable')->where('approved', true)->orderByDesc('created_at');
    }

    /** @return MorphMany<Comment> */
    public function allComments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
