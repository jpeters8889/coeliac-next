<?php

declare(strict_types=1);

namespace App\Http\Controllers\EatingOut\ReportEatery;

use App\Actions\EatingOut\CreateEateryReportAction;
use App\Http\Requests\EatingOut\EateryCreateReportRequest;
use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryCounty;
use App\Models\EatingOut\EateryTown;
use Illuminate\Http\RedirectResponse;

class StoreController
{
    public function __invoke(
        EateryCreateReportRequest $request,
        EateryCounty $county,
        EateryTown $town,
        Eatery $eatery,
        CreateEateryReportAction $createEateryReportAction,
    ): RedirectResponse {
        $createEateryReportAction->handle(
            $eatery,
            $request->string('details')->toString(),
            $request->has('branch_id') ? $request->integer('branch_id') : null,
        );

        return redirect()->back();
    }
}
