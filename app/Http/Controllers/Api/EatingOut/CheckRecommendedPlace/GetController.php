<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\EatingOut\CheckRecommendedPlace;

use App\DataObjects\EatingOut\RecommendAPlaceExistsCheckData;
use App\Pipelines\EatingOut\CheckRecommendedPlace\CheckRecommendedPlacePipeline;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GetController
{
    public function __invoke(Request $request, CheckRecommendedPlacePipeline $checkedRecommendedPlacePipeline): Response
    {
        $data = new RecommendAPlaceExistsCheckData(
            name: $request->has('place_name') ? $request->string('place_name')->toString() : null,
            location: $request->has('place_location') ? $request->string('place_location')->toString() : null,
        );

        $result = $checkedRecommendedPlacePipeline->run($data);

        if ($result->found) {
            return new Response([
                'result' => $result->reason,
                'url' => $result->url,
                'label' => $result->label,
            ]);
        }

        return new Response(status: Response::HTTP_NO_CONTENT);
    }
}
