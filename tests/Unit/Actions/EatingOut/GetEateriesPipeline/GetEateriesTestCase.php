<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\EatingOut\GetEateriesPipeline;

use App\Actions\EatingOut\GetEateriesPipeline\CheckForMissingEateriesAction;
use App\Actions\EatingOut\GetEateriesPipeline\GetEateriesInTownAction;
use App\Actions\EatingOut\GetEateriesPipeline\GetNationwideBranchesInTownAction;
use App\Actions\EatingOut\GetEateriesPipeline\HydrateBranchesAction;
use App\Actions\EatingOut\GetEateriesPipeline\HydrateEateriesAction;
use App\Actions\EatingOut\GetEateriesPipeline\PaginateEateriesAction;
use App\Actions\EatingOut\GetEateriesPipeline\RelateEateriesAndBranchesAction;
use App\Actions\EatingOut\GetEateriesPipeline\SerialiseResultsAction;
use App\Actions\EatingOut\GetEateriesPipeline\SortPendingEateriesAction;
use App\DataObjects\EatingOut\GetEateriesPipelineData;
use App\DataObjects\EatingOut\PendingEatery;
use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryCounty;
use App\Models\EatingOut\EateryFeature;
use App\Models\EatingOut\EateryReview;
use App\Models\EatingOut\EateryTown;
use App\Models\EatingOut\EateryVenueType;
use App\Models\EatingOut\NationwideBranch;
use Database\Seeders\EateryScaffoldingSeeder;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Collection;
use Tests\TestCase;

abstract class GetEateriesTestCase extends TestCase
{
    protected EateryCounty $county;

    protected EateryTown $town;

    protected int $eateriesToCreate = 5;

    protected int $reviewsToCreate = 5;

    protected int $branchesToCreate = 5;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(EateryScaffoldingSeeder::class);

        $this->county = EateryCounty::query()->withoutGlobalScopes()->first();
        $this->town = EateryTown::query()->withoutGlobalScopes()->first();

        $this->build(Eatery::class)
            ->count($this->eateriesToCreate)
            ->sequence(fn (Sequence $sequence) => ['id' => $sequence->index + 1])
            ->create([
                'county_id' => $this->county->id,
                'town_id' => $this->town->id,
                'venue_type_id' => EateryVenueType::query()->first()->id,
            ]);

        EateryFeature::query()->first()->eateries()->attach(Eatery::query()->first());

        $this->county->eateries->each(function (Eatery $eatery, $index): void {
            $this->build(EateryReview::class)
                ->count($this->reviewsToCreate - $index)
                ->create([
                    'wheretoeat_id' => $eatery->id,
                    'rating' => random_int(1, 5),
                    'approved' => true,
                ]);
        });

        if ($this->branchesToCreate) {
            $this->build(NationwideBranch::class)
                ->count($this->branchesToCreate)
                ->create([
                    'county_id' => $this->county->id,
                    'town_id' => $this->town->id,
                ]);
        }
    }

    protected function callGetEateriesAction(Collection $eateries = new Collection(), array $filters = []): ?GetEateriesPipelineData
    {
        $toReturn = null;

        $closure = function (GetEateriesPipelineData $pipelineData) use (&$toReturn): void {
            $toReturn = $pipelineData;
        };

        $pipelineData = new GetEateriesPipelineData(
            town: $this->town,
            filters: $filters,
            eateries: $eateries,
        );

        $this->callAction(GetEateriesInTownAction::class, $pipelineData, $closure);

        return $toReturn;
    }

    protected function callGetBranchesAction(Collection $eateries = new Collection(), array $filters = []): ?GetEateriesPipelineData
    {
        $toReturn = null;

        $closure = function (GetEateriesPipelineData $pipelineData) use (&$toReturn): void {
            $toReturn = $pipelineData;
        };

        $pipelineData = new GetEateriesPipelineData(
            town: $this->town,
            filters: $filters,
            eateries: $eateries,
        );

        $this->callAction(GetNationwideBranchesInTownAction::class, $pipelineData, $closure);

        return $toReturn;
    }

    protected function callSortEateriesAction(Collection $eateries): ?GetEateriesPipelineData
    {
        $toReturn = null;

        $closure = function (GetEateriesPipelineData $pipelineData) use (&$toReturn): void {
            $toReturn = $pipelineData;
        };

        $pipelineData = new GetEateriesPipelineData(
            town: $this->town,
            filters: [],
            eateries: $eateries,
        );

        $this->callAction(SortPendingEateriesAction::class, $pipelineData, $closure);

        return $toReturn;
    }

    protected function callPaginateEateriesAction(Collection $eateries = null): ?GetEateriesPipelineData
    {
        if ( ! $eateries) {
            $eateries = $this->callGetEateriesAction()?->eateries;
            $eateries = $this->callGetBranchesAction($eateries)?->eateries;
        }

        $toReturn = null;

        $closure = function (GetEateriesPipelineData $pipelineData) use (&$toReturn): void {
            $toReturn = $pipelineData;
        };

        $pipelineData = new GetEateriesPipelineData(
            town: $this->town,
            filters: [],
            eateries: $eateries,
        );

        $this->callAction(PaginateEateriesAction::class, $pipelineData, $closure);

        return $toReturn;
    }

    protected function callHydrateEateriesAction(Collection $eateries = null): ?GetEateriesPipelineData
    {
        if ( ! $eateries) {
            $eateries = $this->callGetEateriesAction()?->eateries;
            $eateries = $this->callGetBranchesAction($eateries)?->eateries;
        }

        $toReturn = null;

        $closure = function (GetEateriesPipelineData $pipelineData) use (&$toReturn): void {
            $toReturn = $pipelineData;
        };

        $pipelineData = new GetEateriesPipelineData(
            town: $this->town,
            filters: [],
            eateries: $eateries,
            paginator: $this->callPaginateEateriesAction($eateries)?->paginator
        );

        $this->callAction(HydrateEateriesAction::class, $pipelineData, $closure);

        return $toReturn;
    }

    protected function callHydrateBranchesAction(Collection $eateries = null): ?GetEateriesPipelineData
    {
        if ( ! $eateries) {
            $eateries = $this->callGetEateriesAction()?->eateries;
            $eateries = $this->callGetBranchesAction($eateries)?->eateries;
        }

        $toReturn = null;

        $closure = function (GetEateriesPipelineData $pipelineData) use (&$toReturn): void {
            $toReturn = $pipelineData;
        };

        $pipelineData = new GetEateriesPipelineData(
            town: $this->town,
            filters: [],
            eateries: $eateries,
            paginator: $this->callPaginateEateriesAction($eateries)?->paginator
        );

        $this->callAction(HydrateBranchesAction::class, $pipelineData, $closure);

        return $toReturn;
    }

    protected function callCheckForMissingEateriesAction(GetEateriesPipelineData $pipelineData): ?GetEateriesPipelineData
    {
        $toReturn = null;

        $closure = function (GetEateriesPipelineData $pipelineData) use (&$toReturn): void {
            $toReturn = $pipelineData;
        };

        $this->callAction(CheckForMissingEateriesAction::class, $pipelineData, $closure);

        return $toReturn;
    }

    protected function callRelateEateriesAndBranchesAction(GetEateriesPipelineData $pipelineData): ?GetEateriesPipelineData
    {
        $toReturn = null;

        $closure = function (GetEateriesPipelineData $pipelineData) use (&$toReturn): void {
            $toReturn = $pipelineData;
        };

        $this->callAction(RelateEateriesAndBranchesAction::class, $pipelineData, $closure);

        return $toReturn;
    }

    protected function callSerialiseResultsAction(): ?GetEateriesPipelineData
    {
        $eatery = Eatery::query()->first();
        $branch = NationwideBranch::query()->first();

        $eateries = collect([new PendingEatery(id: $eatery->id, branchId: $branch->id, ordering: 'abc')]);

        $pipelineData = new GetEateriesPipelineData(
            town: $this->town,
            filters: [],
            eateries: $eateries,
            paginator: $eateries->paginate(5),
            hydrated: $this->callHydrateEateriesAction($eateries)->hydrated,
            hydratedBranches: $this->callHydrateBranchesAction($eateries)->hydratedBranches
        );

        $pipelineData = $this->callRelateEateriesAndBranchesAction($pipelineData);

        $toReturn = null;

        $closure = function (GetEateriesPipelineData $pipelineData) use (&$toReturn): void {
            $toReturn = $pipelineData;
        };

        $this->callAction(SerialiseResultsAction::class, $pipelineData, $closure);

        return $toReturn;
    }
}
