<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Recipes;

use App\Actions\Recipes\GetRecipeFiltersForIndexAction;
use App\Contracts\Recipes\FilterableRecipeRelation;
use App\Models\Recipes\Recipe;
use App\Models\Recipes\RecipeAllergen;
use App\Models\Recipes\RecipeFeature;
use App\Models\Recipes\RecipeMeal;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GetRecipeFiltersForIndexActionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('media');
    }

    public static function filterableImplementations(): array
    {
        return [
            'recipe features' => [RecipeFeature::class, 'features'],
            'recipe meals' => [RecipeMeal::class, 'meals'],
            'recipe free from' => [RecipeAllergen::class, 'allergens'],
        ];
    }

    /**
     * @test
     *
     * @dataProvider filterableImplementations
     *
     * @param  class-string<FilterableRecipeRelation>  $relationship
     */
    public function itReturnsTheFilterableRelationshipWithNoFiltersInTheRequest(string $relationship, string $name): void
    {
        $this->build(Recipe::class)
            ->has($this->build($relationship)->count(5), $name)
            ->count(5)
            ->create();

        $this->assertCount(25, $this->callAction(GetRecipeFiltersForIndexAction::class, $relationship));
    }

    /**
     * @test
     *
     * @dataProvider filterableImplementations
     *
     * @param  class-string<FilterableRecipeRelation>  $relationship
     */
    public function itReturnsTheFilterableInstanceThatHasAnAdditionalFeatureFilter(string $relationship, string $name): void
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

        /** @var Collection $features */
        $features = $this->callAction(GetRecipeFiltersForIndexAction::class, $relationship, ['features' => ['feature']]);

        $this->assertCount(1, $features);
        $this->assertEquals(1, data_get($features, '0.recipes_count'));
    }

    /**
     * @test
     *
     * @dataProvider filterableImplementations
     *
     * @param  class-string<FilterableRecipeRelation>  $relationship
     */
    public function itReturnsTheFilterableInstanceThatHasAnAdditionalMealFilter(string $relationship, string $name): void
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

        /** @var Collection $meals */
        $meals = $this->callAction(GetRecipeFiltersForIndexAction::class, $relationship, ['meals' => ['meal']]);

        $this->assertCount(1, $meals);
        $this->assertEquals(1, data_get($meals, '0.recipes_count'));
    }

    /**
     * @test
     *
     * @dataProvider filterableImplementations
     *
     * @param  class-string<FilterableRecipeRelation>  $relationship
     */
    public function itReturnsTheFilterableInstanceThatHasAnAdditionalFreeFromFilter(string $relationship, string $name): void
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

        /** @var Collection $freeFroms */
        $freeFroms = $this->callAction(GetRecipeFiltersForIndexAction::class, $relationship, ['freeFrom' => ['allergen']]);

        $this->assertCount(1, $freeFroms);
        $this->assertEquals(1, data_get($freeFroms, '0.recipes_count'));
    }
}
