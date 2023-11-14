<?php

declare(strict_types=1);

namespace App\Resources\EatingOut;

use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\NationwideBranch;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SimpleEateryResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request)
    {
        /** @var Eatery | NationwideBranch $resource */
        $resource = $this->resource;

        return [
            'name' => $resource instanceof Eatery ? $resource->name : ($resource->name ? "{$resource->name} - {$resource->eatery->name}" : $resource->eatery->name),
            'link' => $resource->link(),
            'location' => [
                'name' => $resource->full_location,
                'link' => $resource->town->link(),
            ],
            'address' => collect(explode("\n", $resource->address))
                ->map(fn (string $line) => trim($line))
                ->join(', '),
            'created_at' => $resource->created_at?->diffForHumans(),
        ];
    }
}
