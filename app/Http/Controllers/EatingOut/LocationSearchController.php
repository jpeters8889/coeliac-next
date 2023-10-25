<?php

declare(strict_types=1);

namespace App\Http\Controllers\EatingOut;

use App\Http\Requests\EatingOut\LocationSearchRequest;
use App\Services\EatingOut\LocationSearchService;
use Illuminate\Http\JsonResponse;

class LocationSearchController
{
    public function __invoke(LocationSearchRequest $request, LocationSearchService $locationSearchService): JsonResponse
    {
        return new JsonResponse([
            'data' => $locationSearchService->search($request->string('term')->toString()),
        ]);
    }
}
