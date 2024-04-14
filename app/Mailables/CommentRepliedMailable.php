<?php

declare(strict_types=1);

namespace App\Mailables;

use App\Infrastructure\MjmlMessage;
use App\Models\Blogs\Blog;
use App\Models\Comments\Comment;
use App\Models\Comments\CommentReply;
use App\Models\Recipes\Recipe;

class CommentRepliedMailable extends BaseMailable
{
    public function __construct(protected CommentReply $reply, ?string $emailKey = null)
    {
        parent::__construct($emailKey);
    }

    public function toMail(): MjmlMessage
    {
        /** @var Comment $comment */
        $comment = $this->reply->comment;

        /** @var Blog | Recipe $commentable */
        $commentable = $comment->commentable;

        return MjmlMessage::make()
            ->subject("Your comment on {$commentable->title} on Coeliac Sanctuary has been replied to!")
            ->mjml('mailables.mjml.comment-replied', $this->baseData([
                'reply' => $this->reply,
                'reason' => 'to let you know your comment on Coeliac Sanctuary has been replied to.',
                'email' => $comment->email,
            ]));
    }
}
