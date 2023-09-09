<?php

declare(strict_types=1);

namespace App\Http\Controllers\EatingOut;

use App\Actions\EatingOut\CreateEateryReviewAction;
use App\Http\Requests\EatingOut\EateryCreateReviewRequest;
use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryCounty;
use App\Models\EatingOut\EateryTown;

class EateryCreateReviewController
{
    public function __invoke(
        EateryCreateReviewRequest $request,
        EateryCounty $county,
        EateryTown $town,
        Eatery $eatery,
        CreateEateryReviewAction $createEateryReviewAction,
    ): void {
        /** @var array $requestData */
        $requestData = $request->validated();

        $createEateryReviewAction->handle($eatery, [
            ...$requestData,
            'ip' => $request->ip(),
            'approved' => $request->shouldReviewBeApproved(),
        ]);
    }
}
