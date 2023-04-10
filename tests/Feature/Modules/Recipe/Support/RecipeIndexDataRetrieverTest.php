<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Recipe\Support;

use App\Modules\Recipe\Models\Recipe;
use App\Modules\Recipe\Models\RecipeAllergen;
use App\Modules\Recipe\Models\RecipeFeature;
use App\Modules\Recipe\Models\RecipeMeal;
use App\Modules\Recipe\Resources\RecipeDetailCardViewResource;
use App\Modules\Recipe\Resources\RecipeListCollection;
use App\Modules\Recipe\Support\RecipeIndexDataRetriever;
use Closure;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;
use Tests\TestCase;

class RecipeIndexDataRetrieverTest extends TestCase
{
    protected RecipeIndexDataRetriever $instance;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withRecipes();

        $this->instance = new RecipeIndexDataRetriever();
    }

    public static function dataKeys(): array
    {
        return [['recipes'], ['features'], ['meals'], ['freeFrom']];
    }

    /** @test */
    public function itReturnsAnArray(): void
    {
        $this->assertIsArray($this->instance->getData());
    }

    /**
     * @test
     * @dataProvider dataKeys
     */
    public function itReturnsAnArrayWithTheCorrectKeys(string $key): void
    {
        $this->assertArrayHasKey($key, $this->instance->getData());
    }

    /**
     * @test
     * @dataProvider dataKeys
     */
    public function itReturnsEachDataItemAsAClosure(string $key): void
    {
        $this->assertInstanceOf(Closure::class, $this->instance->getData()[$key]);
    }

    /** @test */
    public function theRecipesKeyIsARecipeListCollection(): void
    {
        $this->assertInstanceOf(RecipeListCollection::class, $this->instance->getData()['recipes']());
    }

    /** @test */
    public function itTheRecipesArePaginated(): void
    {
        /** @var RecipeListCollection $recipes */
        $recipes = $this->instance->getData()['recipes']();

        $this->assertInstanceOf(Paginator::class, $recipes->resource);
    }

    /** @test */
    public function itReturnsACollectionOfFeatures(): void
    {
        $this->assertInstanceOf(Collection::class, $this->instance->getData()['features']());
    }

    /** @test */
    public function eachFeatureHasTheCorrectKeys(): void
    {
        $this->instance->getData()['features']()
            ->each(function (array $feature): void {
                foreach (['feature', 'slug', 'recipes_count'] as $key) {
                    $this->assertArrayHasKey($key, $feature);
                }
            });
    }

    /** @test */
    public function itReturnsACollectionOfMeals(): void
    {
        $this->assertInstanceOf(Collection::class, $this->instance->getData()['meals']());
    }

    /** @test */
    public function eachMealHasTheCorrectKeys(): void
    {
        $this->instance->getData()['meals']()
            ->each(function (array $meal): void {
                foreach (['meal', 'slug', 'recipes_count'] as $key) {
                    $this->assertArrayHasKey($key, $meal);
                }
            });
    }

    /** @test */
    public function itReturnsACollectionOfFreeFromAllergens(): void
    {
        $this->assertInstanceOf(Collection::class, $this->instance->getData()['freeFrom']());
    }

    /** @test */
    public function eachAllergenHasTheCorrectKeys(): void
    {
        $this->instance->getData()['freeFrom']()
            ->each(function (array $allergen): void {
                foreach (['allergen', 'slug', 'recipes_count'] as $key) {
                    $this->assertArrayHasKey($key, $allergen);
                }
            });
    }

    /** @test */
    public function itWillFilterTheRecipesWhenAGivenFeatureIsPassed(): void
    {
        Recipe::query()->first()->features()->detach();
        Recipe::query()->first()->features()->attach(RecipeFeature::query()->first());

        Recipe::query()->skip(1)->first()->features()->detach();
        Recipe::query()->skip(1)->first()->features()->attach(RecipeFeature::query()->skip(1)->first());

        /** @var RecipeFeature $feature */
        $feature = RecipeFeature::query()->first();

        /** @var RecipeDetailCardViewResource[] $recipes */
        $recipes = $this->instance->getData(['features' => [$feature->slug]])['recipes']()->resource->all();

        $titles = collect($recipes)->map(fn (RecipeDetailCardViewResource $recipe) => $recipe->title);

        $this->assertContains('Recipe 0', $titles);
        $this->assertNotContains('Recipe 1', $titles);
    }

    /** @test */
    public function itWillFilterTheAvailableFeaturesWhenFeaturesArePassedIn(): void
    {
        $feature1 = $this->create(RecipeFeature::class, ['feature' => 'Feature 1', 'slug' => 'feature-1']);
        $feature2 = $this->create(RecipeFeature::class, ['feature' => 'Feature 2', 'slug' => 'feature-2']);

        /** @var Recipe $recipe */
        $recipe = Recipe::query()->first();

        $recipe->features()->detach();
        $recipe->features()->attach([$feature1->id, $feature2->id]);

        $features = $this->instance->getData(['features' => ['feature-1']])['features']();

        $this->assertCount(2, $features);

        $featureSlugs = collect($features)->map(fn (array $feature) => $feature['slug']);

        $this->assertContains('feature-1', $featureSlugs);
        $this->assertContains('feature-2', $featureSlugs);

        $this->assertEquals(1, $features[0]['recipes_count']);
        $this->assertEquals(1, $features[1]['recipes_count']);
    }

    /** @test */
    public function itWillFilterTheAvailableMealsWhenFeaturesArePassedIn(): void
    {
        /** @var RecipeMeal $meal */
        $meal = RecipeMeal::query()->first();

        /** @var Recipe $recipe */
        $recipe = Recipe::query()->first();

        $recipe->meals()->detach();
        $recipe->meals()->attach($meal->id);

        $meals = $this->instance->getData(['features' => [$recipe->features[0]->slug]])['meals']();

        $this->assertCount(1, $meals);

        $this->assertEquals($meal->meal, $meals[0]['meal']);
        $this->assertEquals(1, $meals[0]['recipes_count']);
    }

    /** @test */
    public function itWillFilterTheAvailableFreeFromWhenFeaturesArePassedIn(): void
    {
        /** @var RecipeAllergen $allergen */
        $allergen = RecipeAllergen::query()->first();

        /** @var Recipe $recipe */
        $recipe = Recipe::query()->first();

        $recipe->allergens()->detach();
        $recipe->allergens()->attach($allergen->id);

        $allergens = $this->instance->getData(['features' => [$recipe->features[0]->slug]])['freeFrom']();

        $this->assertCount(1, $allergens);

        $this->assertEquals($allergen->allergen, $allergens[0]['allergen']);
        $this->assertEquals(1, $allergens[0]['recipes_count']);
    }

    /** @test */
    public function itWillFilterTheRecipesWhenAGivenMealIsPassed(): void
    {
        Recipe::query()->first()->meals()->detach();
        Recipe::query()->first()->meals()->attach(RecipeMeal::query()->first());

        Recipe::query()->skip(1)->first()->meals()->detach();
        Recipe::query()->skip(1)->first()->meals()->attach(RecipeMeal::query()->skip(1)->first());

        /** @var RecipeMeal $meal */
        $meal = RecipeMeal::query()->first();

        /** @var RecipeDetailCardViewResource[] $recipes */
        $recipes = $this->instance->getData(['meals' => [$meal->slug]])['recipes']()->resource->all();

        $titles = collect($recipes)->map(fn (RecipeDetailCardViewResource $recipe) => $recipe->title);

        $this->assertContains('Recipe 0', $titles);
        $this->assertNotContains('Recipe 1', $titles);
    }

    /** @test */
    public function itWillFilterTheAvailableFeaturesWhenMealsArePassedIn(): void
    {
        /** @var RecipeFeature $feature */
        $feature = RecipeFeature::query()->first();

        /** @var Recipe $recipe */
        $recipe = Recipe::query()->first();

        $recipe->features()->detach();
        $recipe->features()->attach($feature->id);

        $features = $this->instance->getData(['meals' => [$recipe->meals[0]->slug]])['features']();

        $this->assertCount(1, $features);

        $this->assertEquals($feature->feature, $features[0]['feature']);
        $this->assertEquals(1, $features[0]['recipes_count']);
    }

    /** @test */
    public function itWillFilterTheAvailableMealsWhenMealsArePassedIn(): void
    {
        $meal1 = $this->create(RecipeMeal::class, ['meal' => 'Meal 1', 'slug' => 'meal-1']);
        $meal2 = $this->create(RecipeMeal::class, ['meal' => 'Meal 2', 'slug' => 'meal-2']);

        /** @var Recipe $recipe */
        $recipe = Recipe::query()->first();

        $recipe->meals()->detach();
        $recipe->meals()->attach([$meal1->id, $meal2->id]);

        $meals = $this->instance->getData(['meals' => ['meal-1']])['meals']();

        $this->assertCount(2, $meals);

        $mealSlugs = collect($meals)->map(fn (array $meal) => $meal['slug']);

        $this->assertContains('meal-1', $mealSlugs);
        $this->assertContains('meal-2', $mealSlugs);

        $this->assertEquals(1, $meals[0]['recipes_count']);
        $this->assertEquals(1, $meals[1]['recipes_count']);
    }

    /** @test */
    public function itWillFilterTheAvailableFreeFromWhenMealsArePassedIn(): void
    {
        /** @var RecipeAllergen $allergen */
        $allergen = RecipeAllergen::query()->first();

        /** @var Recipe $recipe */
        $recipe = Recipe::query()->first();

        $recipe->allergens()->detach();
        $recipe->allergens()->attach($allergen->id);

        $allergens = $this->instance->getData(['meals' => [$recipe->meals[0]->slug]])['freeFrom']();

        $this->assertCount(1, $allergens);

        $this->assertEquals($allergen->allergen, $allergens[0]['allergen']);
        $this->assertEquals(1, $allergens[0]['recipes_count']);
    }

    /** @test */
    public function itWillFilterTheRecipesWhenAGivenFreeFromIsPassed(): void
    {
        Recipe::query()->first()->allergens()->detach();
        Recipe::query()->first()->allergens()->attach(RecipeAllergen::query()->first());

        Recipe::query()->skip(1)->first()->allergens()->detach();
        Recipe::query()->skip(1)->first()->allergens()->attach(RecipeAllergen::query()->skip(1)->first());

        /** @var RecipeAllergen $allergen */
        $allergen = RecipeAllergen::query()->first();

        /** @var RecipeDetailCardViewResource[] $recipes */
        $recipes = $this->instance->getData(['freeFrom' => [$allergen->slug]])['recipes']()->resource->all();

        $titles = collect($recipes)->map(fn (RecipeDetailCardViewResource $recipe) => $recipe->title);

        $this->assertContains('Recipe 0', $titles);
        $this->assertNotContains('Recipe 1', $titles);
    }

    /** @test */
    public function itWillFilterTheAvailableFeaturesWhenFreeFromIsPassedIn(): void
    {
        /** @var RecipeFeature $feature */
        $feature = RecipeFeature::query()->first();

        /** @var Recipe $recipe */
        $recipe = Recipe::query()->first();

        $recipe->features()->detach();
        $recipe->features()->attach($feature->id);

        $features = $this->instance->getData(['freeFrom' => [$recipe->allergens[0]->slug]])['features']();

        $this->assertCount(1, $features);

        $this->assertEquals($feature->feature, $features[0]['feature']);
        $this->assertEquals(1, $features[0]['recipes_count']);
    }

    /** @test */
    public function itWillFilterTheAvailableMealsWhenFreeFromIsPassedIn(): void
    {
        /** @var RecipeMeal $meal */
        $meal = RecipeMeal::query()->first();

        /** @var Recipe $recipe */
        $recipe = Recipe::query()->first();

        $recipe->meals()->detach();
        $recipe->meals()->attach($meal->id);

        $meals = $this->instance->getData(['freeFrom' => [$recipe->allergens[0]->slug]])['meals']();

        $this->assertCount(1, $meals);

        $this->assertEquals($meal->meal, $meals[0]['meal']);
        $this->assertEquals(1, $meals[0]['recipes_count']);
    }

    /** @test */
    public function itWillFilterTheAvailableFreeFromWhenFreeFromIsPassedIn(): void
    {
        $allergen1 = $this->create(RecipeAllergen::class, ['allergen' => 'Allergen 1', 'slug' => 'allergen-1']);
        $allergen2 = $this->create(RecipeAllergen::class, ['allergen' => 'Allergen 2', 'slug' => 'allergen-2']);

        /** @var Recipe $recipe */
        $recipe = Recipe::query()->first();

        $recipe->allergens()->detach();
        $recipe->allergens()->attach([$allergen1->id, $allergen2->id]);

        $freeFrom = $this->instance->getData(['freeFrom' => ['allergen-1']])['freeFrom']();

        $this->assertCount(2, $freeFrom);

        $freeFromSlugs = collect($freeFrom)->map(fn (array $allergen) => $allergen['slug']);

        $this->assertContains('allergen-1', $freeFromSlugs);
        $this->assertContains('allergen-2', $freeFromSlugs);

        $this->assertEquals(1, $freeFrom[0]['recipes_count']);
        $this->assertEquals(1, $freeFrom[1]['recipes_count']);
    }
}
