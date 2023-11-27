<?php

declare(strict_types=1);

namespace App\Http\Requests\EatingOut\Api;

use App\DataObjects\EatingOut\LatLng;
use Illuminate\Foundation\Http\FormRequest;

class EatingOutBrowseRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'lat' => ['required', 'numeric'],
            'lng' => ['required', 'numeric'],
            'radius' => ['required', 'numeric'],
            'filter' => ['array'],
            'filter.category' => ['string'],
            'filter.venueTypes' => ['string'],
            'filter.features' => ['string'],
        ];
    }

    public function latLng(): LatLng
    {
        return new LatLng(
            lat: $this->float('lat'),
            lng: $this->float('lng'),
            radius: $this->float('radius'),
        );
    }

    /** @return array{categories: string[] | null, features: string[] | null, venueTypes: string[] | null} */
    public function filters(): array
    {
        return [
            'categories' => $this->has('filter.category') ? explode(',', $this->string('filter.category')->toString()) : null,
            'venueTypes' => $this->has('filter.venueType') ? explode(',', $this->string('filter.venueType')->toString()) : null,
            'features' => $this->has('filter.feature') ? explode(',', $this->string('filter.feature')->toString()) : null,
        ];
    }
}
