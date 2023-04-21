<?php

declare(strict_types=1);

namespace App\Modules\Shared\Comments;

use App\Modules\Shared\Models\Comment;
use Illuminate\Database\Eloquent\Relations\MorphMany;

interface HasComments
{
    /** @return MorphMany<Comment> */
    public function comments(): MorphMany;

    /** @return MorphMany<Comment> */
    public function allComments(): MorphMany;
}
