<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Recipes;

use App\Actions\Recipes\GetRecipesForIndexAction;
use App\Contracts\Recipes\FilterableRecipeRelation;
use App\Models\Recipes\Recipe;
use App\Models\Recipes\RecipeAllergen;
use App\Models\Recipes\RecipeFeature;
use App\Models\Recipes\RecipeMeal;
use App\Resources\Recipes\RecipeDetailCardViewResource;
use App\Resources\Recipes\RecipeListCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GetRecipesForIndexActionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('media');

        $this->withRecipes(15);
    }

    /** @test */
    public function itReturnsARecipeListCollection(): void
    {
        $this->assertInstanceOf(
            RecipeListCollection::class,
            $this->callAction(GetRecipesForIndexAction::class),
        );
    }

    /** @test */
    public function itIsAPaginatedCollection(): void
    {
        $recipes = $this->callAction(GetRecipesForIndexAction::class);

        $this->assertInstanceOf(LengthAwarePaginator::class, $recipes->resource);
    }

    /** @test */
    public function itReturns12ItemsPerPageByDefault(): void
    {
        $this->assertCount(12, $this->callAction(GetRecipesForIndexAction::class));
    }

    /** @test */
    public function itCanHaveADifferentPageLimitSpecified(): void
    {
        $this->assertCount(5, $this->callAction(GetRecipesForIndexAction::class, perPage: 5));
    }

    /** @test */
    public function eachItemInThePageIsARecipeDetailCardViewResource(): void
    {
        $resource = $this->callAction(GetRecipesForIndexAction::class)->resource->first();

        $this->assertInstanceOf(RecipeDetailCardViewResource::class, $resource);
    }

    /** @test */
    public function itLoadsTheMediaFeaturesAndNutritionRelationship(): void
    {
        /** @var Recipe $recipe */
        $recipe = $this->callAction(GetRecipesForIndexAction::class)->resource->first()->resource;

        $this->assertTrue($recipe->relationLoaded('media'));
        $this->assertTrue($recipe->relationLoaded('features'));
        $this->assertTrue($recipe->relationLoaded('nutrition'));
    }

    /**
     * @test
     *
     * @dataProvider filterableImplementations
     *
     * @param  class-string<FilterableRecipeRelation>  $relationship
     */
    public function itCanBeFiltered(string $relationship, string $name, string $filter, string $search): void
    {
        $this->build(Recipe::class)
            ->has($this->build($relationship)->count(5), $name)
            ->count(5)
            ->create();

        $feature = $this->create(RecipeFeature::class, ['slug' => 'feature']);
        $meal = $this->create(RecipeMeal::class, ['slug' => 'meal']);
        $allergen = $this->create(RecipeAllergen::class, ['slug' => 'allergen']);

        /** @var Recipe $recipe */
        $recipe = $this->create(Recipe::class);

        $recipe->features()->attach($feature);
        $recipe->meals()->attach($meal);
        $recipe->allergens()->attach($allergen);

        $recipes = $this->callAction(GetRecipesForIndexAction::class, [$filter => [$search]]);

        $this->assertCount(1, $recipes->resource);
    }

    /** @test */
    public function itCanBeSearched(): void
    {
        Recipe::query()->first()->update(['title' => 'Test Recipe Yay']);

        $recipes = $this->callAction(GetRecipesForIndexAction::class, search: 'Test Recipe');

        $this->assertCount(1, $recipes->resource);
    }

    public static function filterableImplementations(): array
    {
        return [
            'recipe features' => [RecipeFeature::class, 'features', 'features', 'feature'],
            'recipe meals' => [RecipeMeal::class, 'meals', 'meals', 'meal'],
            'recipe free from' => [RecipeAllergen::class, 'allergens', 'freeFrom', 'allergen'],
        ];
    }
}
