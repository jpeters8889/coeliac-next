<?php

declare(strict_types=1);

namespace App\Services\EatingOut;

use App\DataObjects\EatingOut\LatLng;
use Illuminate\Http\Client\Factory as HttpFactory;
use Illuminate\Support\Collection;
use RuntimeException;

class LocationSearchService
{
    public function __construct(protected HttpFactory $httpFactory)
    {
        //
    }

    /** @return Collection<int, LatLng> */
    public function search(string $term): Collection
    {
        return $this->callSearchService($term)
            ->map(fn (array $result): LatLng => new LatLng($result['lat'], $result['lng'], $result['display_name']));
    }

    public function getLatLng(string $term): LatLng
    {
        /** @var array{lat: float, lng: float, display_name: string} $result */
        $result = $this->callSearchService($term)->first();

        return new LatLng($result['lat'], $result['lng'], $result['display_name']);
    }

    /** @return Collection<int, array{lat: float, lng: float, display_name: string}> */
    protected function callSearchService(string $term): Collection
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

        return $collection;
    }
}
