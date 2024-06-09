<?php

declare(strict_types=1);

namespace Tests\Unit\Pipelines\Search\Steps;

use App\DataObjects\Search\SearchParameters;
use App\DataObjects\Search\SearchPipelineData;
use App\DataObjects\Search\SearchResultsCollection;
use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\NationwideBranch;
use App\Pipelines\Search\Steps\SearchEateries;
use Database\Seeders\EateryScaffoldingSeeder;
use Tests\TestCase;

class SearchEateriesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(EateryScaffoldingSeeder::class);
    }

    /** @test */
    public function itDoesntSearchAnyShopEateriesIfTheEaterySearchParameterIsFalse(): void
    {
        $eatery = $this->create(Eatery::class, ['name' => 'Foo']);
        $this->create(NationwideBranch::class, [
            'name' => 'Foo',
            'wheretoeat_id' => $eatery->id,
        ]);

        $searchParams = new SearchParameters(
            term: 'foo',
            eateries: false,
        );

        $pipelineData = new SearchPipelineData(
            $searchParams,
            new SearchResultsCollection(),
        );

        $closure = function (SearchPipelineData $data): void {
            $this->assertEmpty($data->results->eateries);
        };

        app(SearchEateries::class)->handle($pipelineData, $closure);
    }

    /** @test */
    public function itSearchesEateries(): void
    {
        /** @var Eatery $eatery */
        $eatery = $this->create(Eatery::class, ['name' => 'Foo']);

        $searchParams = new SearchParameters(
            term: 'foo',
            eateries: true,
        );

        $pipelineData = new SearchPipelineData(
            $searchParams,
            new SearchResultsCollection(),
        );

        $closure = function (SearchPipelineData $data) use ($eatery): void {
            $this->assertNotEmpty($data->results->eateries);
            $this->assertEquals($eatery->id, $data->results->eateries->first()->id);
        };

        app(SearchEateries::class)->handle($pipelineData, $closure);
    }
}
