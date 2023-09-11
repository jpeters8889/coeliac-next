<?php

declare(strict_types=1);

namespace App\Http\Controllers\EatingOut;

use App\Actions\EatingOut\CreateEateryReportAction;
use App\Http\Requests\EatingOut\EateryCreateReportRequest;
use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryCounty;
use App\Models\EatingOut\EateryTown;
use Illuminate\Http\RedirectResponse;

class EateryCreateReportController
{
    public function __invoke(
        EateryCreateReportRequest $request,
        EateryCounty $county,
        EateryTown $town,
        Eatery $eatery,
        CreateEateryReportAction $createEateryReportAction,
    ): RedirectResponse {
        $createEateryReportAction->handle($eatery, $request->validated('details'));

        return redirect()->back();
    }
}
