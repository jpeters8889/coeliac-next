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
            ->map(fn (array $result): LatLng => new LatLng((float) $result['lat'], (float) $result['lon'], $result['display_name']));
    }

    public function getLatLng(string $term): LatLng
    {
        /** @var array{lat: float, lon: float, display_name: string} $result */
        $result = $this->callSearchService($term)->first();

        return new LatLng((float) $result['lat'], (float) $result['lon'], $result['display_name']);
    }

    /** @return Collection<int, array{lat: float, lon: float, display_name: string, type: string}> */
    protected function callSearchService(string $term): Collection
    {
        $response = $this->httpFactory
            ->get('https://nominatim.openstreetmap.org/search.php', [
                'q' => $term,
                'countrycodes' => 'gb,ie',
                'format' => 'jsonv2',
            ]);

        if ($response->failed()) {
            throw new RuntimeException('Http request failed');
        }

        $allowedTypes = ['administrative', 'postcode'];

        /** @var Collection<int, array{lat: float, lon: float, display_name: string, type: string}> $collection */
        $collection = $response->collect();

        return $collection->filter(fn (array $item) => in_array($item['type'], $allowedTypes));
    }
}
