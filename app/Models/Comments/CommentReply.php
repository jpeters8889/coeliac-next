<?php

declare(strict_types=1);

namespace App\Models\Comments;

use App\Concerns\DisplaysDates;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommentReply extends Model
{
    use DisplaysDates;

    /** @return BelongsTo<Comment, CommentReply> */
    public function comment(): BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }
}
