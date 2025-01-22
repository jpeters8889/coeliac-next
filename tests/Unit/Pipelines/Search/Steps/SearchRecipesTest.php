<?php

declare(strict_types=1);

namespace Tests\Unit\Pipelines\Search\Steps;

use PHPUnit\Framework\Attributes\Test;
use App\DataObjects\Search\SearchParameters;
use App\DataObjects\Search\SearchPipelineData;
use App\DataObjects\Search\SearchResultsCollection;
use App\Models\Recipes\Recipe;
use App\Pipelines\Search\Steps\SearchRecipes;
use Tests\TestCase;

class SearchRecipesTest extends TestCase
{
    #[Test]
    public function itDoesntSearchAnyRecipesIfTheRecipeSearchParameterIsFalse(): void
    {
        $this->create(Recipe::class, ['title' => 'Foo']);

        $searchParams = new SearchParameters(
            term: 'foo',
            recipes: false,
        );

        $pipelineData = new SearchPipelineData(
            $searchParams,
            new SearchResultsCollection(),
        );

        $closure = function (SearchPipelineData $data): void {
            $this->assertEmpty($data->results->recipes);
        };

        app(SearchRecipes::class)->handle($pipelineData, $closure);
    }

    #[Test]
    public function itSearchesRecipes(): void
    {
        /** @var Recipe $recipe */
        $recipe = $this->create(Recipe::class, ['title' => 'Foo']);

        $searchParams = new SearchParameters(
            term: 'foo',
            recipes: true,
        );

        $pipelineData = new SearchPipelineData(
            $searchParams,
            new SearchResultsCollection(),
        );

        $closure = function (SearchPipelineData $data) use ($recipe): void {
            $this->assertNotEmpty($data->results->recipes);
            $this->assertEquals($recipe->id, $data->results->recipes->first()->id);
        };

        app(SearchRecipes::class)->handle($pipelineData, $closure);
    }
}
