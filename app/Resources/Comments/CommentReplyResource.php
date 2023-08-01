<?php

declare(strict_types=1);

namespace App\Resources\Comments;

use App\Models\Comments\CommentReply;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin CommentReply */
class CommentReplyResource extends JsonResource
{
    /** @return array{comment: string, published: string} */
    public function toArray(Request $request)
    {
        return [
            'comment' => $this->comment_reply,
            'published' => $this->published,
        ];
    }
}
