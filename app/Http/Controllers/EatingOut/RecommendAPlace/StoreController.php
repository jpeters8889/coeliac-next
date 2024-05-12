<?php

declare(strict_types=1);

namespace App\Http\Controllers\EatingOut\RecommendAPlace;

use App\Actions\EatingOut\CreatePlaceRecommendationAction;
use App\Http\Requests\EatingOut\RecommendAPlaceRequest;
use Illuminate\Http\RedirectResponse;

class StoreController
{
    public function __invoke(RecommendAPlaceRequest $request, CreatePlaceRecommendationAction $createPlaceRecommendationAction): RedirectResponse
    {
        /** @var array $data */
        $data = $request->validated();

        $createPlaceRecommendationAction->handle($data);

        return redirect()->route('eating-out.recommend.index');
    }
}
