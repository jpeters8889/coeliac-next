<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\EatingOut\LatLng;

use App\Http\Requests\EatingOut\Api\LatLngSearchRequest;
use Spatie\Geocoder\Geocoder;

class GetController
{
    public function __invoke(LatLngSearchRequest $request, Geocoder $geocoder): array
    {
        $result = $geocoder->getCoordinatesForAddress($request->string('term')->toString());

        return [
            'lat' => $result['lat'],
            'lng' => $result['lng'],
        ];
    }
}
