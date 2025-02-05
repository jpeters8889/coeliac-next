<?php

declare(strict_types=1);

namespace App\Contracts\Comments;

use App\Models\Comments\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/** @template T of Model */
interface HasComments
{
    /** @return MorphMany<Comment, T> */
    public function comments(): MorphMany;

    /** @return MorphMany<Comment, T> */
    public function allComments(): MorphMany;
}
