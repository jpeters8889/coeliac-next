<?php

declare(strict_types=1);

namespace App\Resources\EatingOut;

use App\DataObjects\EatingOut\PendingEatery;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin PendingEatery */
class EateryBrowseResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request)
    {
        return [
            'key' => $this->id . ($this->branchId ? '-' . $this->branchId : null),
            'isNationwideBranch' => $this->branchId !== null,
            'location' => [
                'lat' => $this->lat,
                'lng' => $this->lng,
            ],
        ];
    }
}
