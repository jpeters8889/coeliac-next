<?php

declare(strict_types=1);

namespace App\Events\EatingOut;

use App\Models\EatingOut\EateryReview;
use Illuminate\Foundation\Events\Dispatchable;

class EateryReviewApprovedEvent
{
    use Dispatchable;

    public function __construct(public EateryReview $eateryReview)
    {
    }
}
