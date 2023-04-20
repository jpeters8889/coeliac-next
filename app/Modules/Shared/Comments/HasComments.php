<?php

namespace App\Modules\Shared\Comments;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface HasComments
{
    public function comments(): MorphMany;

    public function allComments(): MorphMany;
}
