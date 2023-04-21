<?php

declare(strict_types=1);

namespace App\Modules\Shared\Models;

use App\Modules\Shared\Support\DisplaysDates;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $comment_reply
 * @property string $published
 */
class CommentReply extends Model
{
    use DisplaysDates;

    /** @return BelongsTo<Comment, CommentReply> */
    public function comment(): BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }
}
