<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Infrastructure\MjmlMessage;
use App\Infrastructure\Notification;
use App\Mailables\CommentApprovedMailable;
use App\Models\Comments\Comment;
use App\Models\Shop\ShopCustomer;
use App\Models\User;
use Illuminate\Notifications\AnonymousNotifiable;

class CommentApprovedNotification extends Notification
{
    public function __construct(protected Comment $comment)
    {
        //
    }

    public function toMail(User|ShopCustomer|AnonymousNotifiable|null $notifiable = null): MjmlMessage
    {
        return CommentApprovedMailable::make($this->comment, $this->key);
    }
}
