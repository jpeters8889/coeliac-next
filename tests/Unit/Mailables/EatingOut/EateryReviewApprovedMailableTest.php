<?php

declare(strict_types=1);

namespace Tests\Unit\Mailables\EatingOut;

use PHPUnit\Framework\Attributes\Test;
use App\Infrastructure\MjmlMessage;
use App\Mailables\EatingOut\EateryReviewApprovedMailable;
use App\Models\EatingOut\EateryReview;
use Tests\TestCase;

class EateryReviewApprovedMailableTest extends TestCase
{
    #[Test]
    public function itReturnsAnMjmlMessageInstance(): void
    {
        $this->assertInstanceOf(
            MjmlMessage::class,
            EateryReviewApprovedMailable::make($this->create(EateryReview::class), 'foo'),
        );
    }

    #[Test]
    public function itHasTheSubjectSet(): void
    {
        /** @var EateryReview $eateryReview */
        $eateryReview = $this->create(EateryReview::class);

        $mailable = EateryReviewApprovedMailable::make($eateryReview, 'foo');

        $this->assertEquals("Your review of {$eateryReview->eatery->name} on Coeliac Sanctuary has been approved!", $mailable->subject);
    }

    #[Test]
    public function itHasTheCorrectView(): void
    {
        $mailable = EateryReviewApprovedMailable::make($this->create(EateryReview::class), 'foo');

        $this->assertEquals('mailables.mjml.eating-out.review-approved', $mailable->mjml);
    }

    #[Test]
    public function itHasTheCorrectData(): void
    {
        /** @var EateryReview $eateryReview */
        $eateryReview = $this->create(EateryReview::class);

        $data = [
            'eateryReview' => fn ($assertionReview) => $this->assertTrue($eateryReview->is($assertionReview)),
            'email' => fn ($email) => $this->assertEquals($eateryReview->email, $email),
            'reason' => fn ($reason) => $this->assertEquals('to let you know your review on Coeliac Sanctuary has been approved.', $reason),
        ];

        $mailable = EateryReviewApprovedMailable::make($eateryReview, 'foo');
        $emailData = $mailable->data();

        foreach ($data as $key => $closure) {
            $this->assertArrayHasKey($key, $emailData);
            $closure($emailData[$key]);
        }
    }
}
