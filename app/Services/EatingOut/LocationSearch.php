<?php

declare(strict_types=1);

namespace App\Services\EatingOut;

use App\DataObjects\EatingOut\LatLng;
use Illuminate\Http\Client\Factory as HttpFactory;
use Illuminate\Support\Collection;
use RuntimeException;

class LocationSearch
{
    public function __construct(protected HttpFactory $httpFactory)
    {
        //
    }

    public function search(string $term): LatLng
    {
        $response = $this->httpFactory
            ->get('https://nominatim.openstreetmap.org/search.php', [
                'q' => $term,
                'countryCodes' => 'gb,ie',
                'format' => 'jsonv2',
            ]);

        if ($response->failed()) {
            throw new RuntimeException('Http request failed');
        }

        /** @var Collection<int, array{lat: float, lng: float, display_name: string}> $collection */
        $collection = $response->collect();

        /** @var LatLng $latLng */
        $latLng = $collection
            ->map(fn (array $result): LatLng => new LatLng($result['lat'], $result['lng'], $result['display_name']))
            ->first();

        return $latLng;
    }
}
