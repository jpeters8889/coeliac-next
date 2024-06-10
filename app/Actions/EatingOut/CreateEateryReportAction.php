<?php

declare(strict_types=1);

namespace App\Actions\EatingOut;

use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryReport;

class CreateEateryReportAction
{
    public function handle(Eatery $eatery, string $details, ?int $branchId = null): EateryReport
    {
        return $eatery->reports()->create([
            'details' => $details,
            'branch_id' => $branchId,
        ]);
    }
}
