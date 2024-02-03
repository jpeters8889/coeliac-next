<?php

declare(strict_types=1);

namespace App\Http\Controllers\Shop;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class AddressSearchGetController
{
    public function __invoke(string $id): array
    {
        $response = Http::getAddress()
            ->get("/get/{$id}")
            ->json();

        $line3 = Arr::get($response, 'line_3');

        if (Arr::get($response, 'line_4') !== '') {
            $line3 .= ', ' . Arr::get($response, 'line_4');
        }

        return [
            'address_1' => Arr::get($response, 'line_1'),
            'address_2' => Arr::get($response, 'line_2'),
            'address_3' => $line3,
            'town' => Arr::get($response, 'town_or_city'),
            'county' => Arr::get($response, 'county'),
            'postcode' => Arr::get($response, 'postcode'),
        ];
    }
}
