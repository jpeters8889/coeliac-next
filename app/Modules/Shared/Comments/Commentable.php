<?php

declare(strict_types=1);

namespace App\Modules\Shared\Comments;

use App\Modules\Shared\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/** @mixin Model */
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
