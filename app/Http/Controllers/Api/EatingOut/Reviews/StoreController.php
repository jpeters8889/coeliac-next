<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\EatingOut\Reviews;

use App\Actions\EatingOut\CreateEateryReviewAction;
use App\Http\Requests\EatingOut\EateryCreateReviewRequest;
use App\Models\EatingOut\Eatery;

class StoreController
{
    public function __invoke(EateryCreateReviewRequest $request, CreateEateryReviewAction $createEateryReviewAction, Eatery $eatery): void
    {
        /** @var array $requestData */
        $requestData = $request->validated();

        $createEateryReviewAction->handle($eatery, [
            ...$requestData,
            'ip' => $request->ip(),
            'approved' => $request->wantsJson() && $request->shouldReviewBeApproved(),
        ]);
    }
}
