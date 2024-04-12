<?php

declare(strict_types=1);

namespace App\Mailables\EatingOut;

use App\Infrastructure\MjmlMessage;
use App\Mailables\BaseMailable;
use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryReview;

class EateryReviewApprovedMailable extends BaseMailable
{
    public function __construct(protected EateryReview $eateryReview, ?string $emailKey = null)
    {
        parent::__construct($emailKey);
    }

    public function toMail(): MjmlMessage
    {
        /** @var Eatery $eatery */
        $eatery = $this->eateryReview->eatery;

        return MjmlMessage::make()
            ->subject("Your review of {$eatery->name} on Coeliac Sanctuary has been approved!")
            ->mjml('mailables.mjml.eating-out.review-approved', $this->baseData([
                'eateryReview' => $this->eateryReview,
                'reason' => 'to let you know your review on Coeliac Sanctuary has been approved.',
                'email' => $this->eateryReview->email,
            ]));
    }
}
