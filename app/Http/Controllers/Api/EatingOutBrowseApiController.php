<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\EatingOut\Api\EatingOutBrowseRequest;
use App\Pipelines\EatingOut\BrowseEateriesPipeline;

class EatingOutBrowseApiController
{
    public function __invoke(EatingOutBrowseRequest $request, BrowseEateriesPipeline $browseEateriesPipeline): array
    {
        return [
            'data' => $browseEateriesPipeline->run($request->latLng(), $request->filters()),
        ];
    }
}
