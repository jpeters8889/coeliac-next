<?php

declare(strict_types=1);

namespace App\DataObjects\EatingOut;

use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryTown;
use App\Models\EatingOut\NationwideBranch;
use App\Resources\EatingOut\EateryListResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

class GetEateriesPipelineData extends Data
{
    /**
     * @param  array{categories: string[], features: string[], venueTypes: string []}  $filters
     * @param  null | Collection<int, PendingEatery>  $eateries
     * @param  null | LengthAwarePaginator<PendingEatery>  $paginator
     * @param  null | Collection<int, Eatery>  $hydrated
     * @param  null | Collection<int, NationwideBranch>  $hydratedBranches
     * @param  class-string<JsonResource>  $jsonResource,
     * @param  null | LengthAwarePaginator<JsonResource>  $serialisedEateries
     */
    public function __construct(
        public EateryTown $town,
        public array $filters,
        public ?Collection $eateries = null,
        public ?LengthAwarePaginator $paginator = null,
        public ?Collection $hydrated = null,
        public ?Collection $hydratedBranches = null,
        public string $jsonResource = EateryListResource::class,
        public ?LengthAwarePaginator $serialisedEateries = null,
    ) {
    }
}
