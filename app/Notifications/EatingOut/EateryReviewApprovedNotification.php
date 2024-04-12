<?php

declare(strict_types=1);

namespace App\Notifications\EatingOut;

use App\Infrastructure\MjmlMessage;
use App\Infrastructure\Notification;
use App\Mailables\EatingOut\EateryReviewApprovedMailable;
use App\Models\EatingOut\EateryReview;
use App\Models\Shop\ShopCustomer;
use App\Models\User;
use Illuminate\Notifications\AnonymousNotifiable;

class EateryReviewApprovedNotification extends Notification
{
    public function __construct(protected EateryReview $eateryReview)
    {
        //
    }

    public function toMail(User|ShopCustomer|AnonymousNotifiable|null $notifiable = null): MjmlMessage
    {
        return EateryReviewApprovedMailable::make($this->eateryReview, $this->key);
    }
}
