<?php

declare(strict_types=1);

namespace App\Contracts\Comments;

use App\Models\Comments\Comment;
use Illuminate\Database\Eloquent\Relations\MorphMany;

interface HasComments
{
    /** @return MorphMany<Comment> */
    public function comments(): MorphMany;

    /** @return MorphMany<Comment> */
    public function allComments(): MorphMany;
}
