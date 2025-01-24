<?php

declare(strict_types=1);

namespace App\Actions;

use Spatie\MailcoachSdk\Mailcoach;

class SignUpToNewsletterAction
{
    public function __construct(protected Mailcoach $mailcoach) {}

    public function handle(string $emailAddress): void
    {
        $this->mailcoach->createSubscriber(config('mailcoach-sdk.newsletter_id'), [
            'email' => $emailAddress,
            'skip_confirmation' => true,
        ]);
    }
}
