<?php

declare(strict_types=1);

namespace Tests\Unit\Pipelines\EatingOut;

use App\Actions\EatingOut\GetEateriesPipeline\AppendDistanceToBranches;
use App\Actions\EatingOut\GetEateriesPipeline\AppendDistanceToEateries;
use App\Actions\EatingOut\GetEateriesPipeline\CheckForMissingEateriesAction;
use App\Actions\EatingOut\GetEateriesPipeline\GetEateriesInSearchArea;
use App\Actions\EatingOut\GetEateriesPipeline\GetNationwideBranchesInSearchArea;
use App\Actions\EatingOut\GetEateriesPipeline\HydrateBranchesAction;
use App\Actions\EatingOut\GetEateriesPipeline\HydrateEateriesAction;
use App\Actions\EatingOut\GetEateriesPipeline\PaginateEateriesAction;
use App\Actions\EatingOut\GetEateriesPipeline\RelateEateriesAndBranchesAction;
use App\Actions\EatingOut\GetEateriesPipeline\SerialiseResultsAction;
use App\Actions\EatingOut\GetEateriesPipeline\SortPendingEateriesAction;
use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryFeature;
use App\Models\EatingOut\EateryReview;
use App\Models\EatingOut\EaterySearchTerm;
use App\Models\EatingOut\EateryVenueType;
use App\Models\EatingOut\NationwideBranch;
use App\Pipelines\EatingOut\GetSearchResultsPipeline;
use Database\Seeders\EateryScaffoldingSeeder;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GetSearchResultsPipelineTest extends TestCase
{
    protected EaterySearchTerm $eaterySearchTerm;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(EateryScaffoldingSeeder::class);

        Http::preventStrayRequests();
        $london = ['lat' => 51.50, 'lng' => 0.12, 'display_name' => 'London'];
        $edinburgh = ['lat' => 55.95, 'lng' => -3.18, 'display_name' => 'Edinburgh'];

        Eatery::query()->update([
            'lat' => $london['lat'],
            'lng' => $london['lng'],
        ]);

        Http::fake(['*' => Http::response([$london, $edinburgh])]);

        $this->eaterySearchTerm = $this->create(EaterySearchTerm::class, [
            'term' => 'London',
        ]);

        $eateries = $this->build(Eatery::class)
            ->count(10)
            ->sequence(fn (Sequence $sequence) => ['id' => $sequence->index + 1])
            ->create([
                'venue_type_id' => EateryVenueType::query()->first()->id,
                'lat' => $london['lat'],
                'lng' => $london['lng'],
            ]);

        EateryFeature::query()->first()->eateries()->attach(Eatery::query()->first());

        $eateries->each(function (Eatery $eatery, $index): void {
            $this->build(EateryReview::class)
                ->count(10 - $index)
                ->create([
                    'wheretoeat_id' => $eatery->id,
                    'rating' => random_int(1, 5),
                    'approved' => true,
                ]);
        });

        $this->build(NationwideBranch::class)
            ->count(10)
            ->create([
                'lat' => $london['lat'],
                'lng' => $london['lng'],
            ]);


    }

    /** @test */
    public function itCallsTheActions(): void
    {
        $this->expectPipelineToExecute(GetEateriesInSearchArea::class);
        $this->expectPipelineToExecute(GetNationwideBranchesInSearchArea::class);
        $this->expectPipelineToExecute(SortPendingEateriesAction::class);
        $this->expectPipelineToExecute(PaginateEateriesAction::class);
        $this->expectPipelineToExecute(HydrateEateriesAction::class);
        $this->expectPipelineToExecute(AppendDistanceToEateries::class);
        $this->expectPipelineToExecute(HydrateBranchesAction::class);
        $this->expectPipelineToExecute(AppendDistanceToBranches::class);
        $this->expectPipelineToExecute(CheckForMissingEateriesAction::class);
        $this->expectPipelineToExecute(RelateEateriesAndBranchesAction::class);
        $this->expectPipelineToExecute(SerialiseResultsAction::class);

        $this->runPipeline(GetSearchResultsPipeline::class, $this->eaterySearchTerm, []);
    }
}
