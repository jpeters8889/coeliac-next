<?php

declare(strict_types=1);

namespace Tests\Unit\Events\EatingOut;

use App\Events\EatingOut\EateryReviewApprovedEvent;
use App\Listeners\EatingOut\SendEateryReviewApprovedNotification;
use App\Models\EatingOut\EateryReview;
use Tests\TestCase;

class EateryReviewApprovedEventTest extends TestCase
{
    /** @test */
    public function itIsHandledByTheSendOrderShippedNotificationListener(): void
    {
        $this->mock(SendEateryReviewApprovedNotification::class)
            ->shouldReceive('handle')
            ->once();

        EateryReviewApprovedEvent::dispatch(new EateryReview());
    }
}
