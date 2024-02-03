<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\EatingOut;

class NationwideCreateReportTest extends EateryCreateReportTest
{
    protected function route(?string $eatery = null): string
    {
        if ( ! $eatery) {
            $eatery = $this->eatery->slug;
        }

        return route('eating-out.nationwide.show.report.create', ['eatery' => $eatery]);
    }
}
