<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\EatingOut\RecommendAPlace;

use App\Actions\EatingOut\CreatePlaceRecommendationAction;
use App\Http\Requests\EatingOut\RecommendAPlaceRequest;
use Illuminate\Http\Response;

class StoreController
{
    public function __invoke(RecommendAPlaceRequest $request, CreatePlaceRecommendationAction $createPlaceRecommendationAction): Response
    {
        /** @var array $data */
        $data = $request->validated();

        $createPlaceRecommendationAction->handle($data);

        return new Response(['data' => 'ok']);
    }
}
