<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Infrastructure\MjmlMessage;
use App\Infrastructure\Notification;
use App\Mailables\CommentRepliedMailable;
use App\Models\Comments\CommentReply;
use App\Models\Shop\ShopCustomer;
use App\Models\User;
use Illuminate\Notifications\AnonymousNotifiable;

class CommentRepliedNotification extends Notification
{
    public function __construct(protected CommentReply $reply)
    {
        //
    }

    public function toMail(User|ShopCustomer|AnonymousNotifiable|null $notifiable = null): MjmlMessage
    {
        return CommentRepliedMailable::make($this->reply, $this->key);
    }
}
