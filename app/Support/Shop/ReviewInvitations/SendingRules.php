<?php

declare(strict_types=1);

namespace App\Support\Shop\ReviewInvitations;

use App\DataObjects\Shop\ReviewInvitationRule;
use App\Enums\Shop\PostageArea;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class SendingRules
{
    /** @return Collection<int, ReviewInvitationRule> */
    public static function get(): Collection
    {
        return collect([
            new ReviewInvitationRule(Carbon::now()->subDays(10)->toImmutable(), [PostageArea::UK->value], '10 days'),
            new ReviewInvitationRule(Carbon::now()->subWeeks(2)->toImmutable(), [PostageArea::EUROPE->value], '2 weeks'),
            new ReviewInvitationRule(Carbon::now()->subWeeks(3)->toImmutable(), [PostageArea::AMERICA->value, PostageArea::OCEANA->value], '3 weeks'),
        ]);
    }
}
