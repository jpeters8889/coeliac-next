<?php

declare(strict_types=1);

namespace App\Resources\EatingOut\Api;

use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\NationwideBranch;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Eatery | NationwideBranch */
class EateryApiResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $name = $this->name;

        if ($this->resource instanceof NationwideBranch) {
            $eateryName = $this->eatery?->name;

            $name = $name ? "{$name} - {$eateryName}" : $eateryName;
        }

        return [
            'id' => $this->id,
            'name' => $name,
            'full_location' => $this->short_location,
            'created_at' => $this->created_at?->diffForHumans(),
        ];
    }
}
