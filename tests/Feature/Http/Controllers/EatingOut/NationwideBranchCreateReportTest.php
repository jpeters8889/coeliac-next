<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\EatingOut;

use App\Models\EatingOut\NationwideBranch;

class NationwideBranchCreateReportTest extends NationwideCreateReportTest
{
    protected NationwideBranch $nationwideBranch;

    protected function setUp(): void
    {
        parent::setUp();

        $this->nationwideBranch = $this->create(NationwideBranch::class, [
            'wheretoeat_id' => $this->eatery->id,
        ]);
    }

    protected function route(?string $eatery = null): string
    {
        if ( ! $eatery) {
            $eatery = $this->eatery->slug;
        }

        return route('eating-out.nationwide.show.branch.report.create', [
            'eatery' => $eatery,
            'nationwideBranch' => $this->nationwideBranch->slug,
        ]);
    }
}
