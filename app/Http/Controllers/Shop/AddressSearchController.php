<?php

declare(strict_types=1);

namespace App\Http\Controllers\Shop;

use App\Http\Requests\Shop\AddressSearchRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class AddressSearchController
{
    /** @return Collection<int, array{id: string, address: string}> */
    public function __invoke(AddressSearchRequest $request): Collection
    {
        $payload = [];

        if ($request->has('country')) {
            $country = $request->string('country')->toString();

            if ($country === 'United Kingdom') {
                $country = 'UK';
            }

            $payload['filter'] = [
                'country' => $country,
            ];
        }

        if ($request->has('lat') && $request->has('lng')) {
            $payload['location'] = [
                'latitude' => $request->float('lat'),
                'longitude' => $request->float('lng'),
            ];
        }

        return Http::getAddress()
            ->post("/autocomplete/{$request->string('search')->toString()}", $payload)
            ->collect('suggestions')
            ->map(fn (array $result) => Arr::only($result, ['id', 'address']));
    }
}
