<?php

declare(strict_types=1);

namespace App\Listeners\EatingOut;

use App\Events\EatingOut\EateryReviewApprovedEvent;
use App\Notifications\EatingOut\EateryReviewApprovedNotification;
use Illuminate\Notifications\AnonymousNotifiable;

class SendEateryReviewApprovedNotification
{
    public function handle(EateryReviewApprovedEvent $event): void
    {
        $eateryReview = $event->eateryReview;

        (new AnonymousNotifiable())
            ->route('mail', [$eateryReview->email => $eateryReview->name])
            ->notify(new EateryReviewApprovedNotification($eateryReview));
    }
}
