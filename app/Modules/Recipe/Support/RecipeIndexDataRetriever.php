<?php

declare(strict_types=1);

namespace App\Modules\Recipe\Support;

use App\Modules\Recipe\Models\Recipe;
use App\Modules\Recipe\Models\RecipeAllergen;
use App\Modules\Recipe\Models\RecipeFeature;
use App\Modules\Recipe\Models\RecipeMeal;
use App\Modules\Recipe\Resources\RecipeListCollection;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class RecipeIndexDataRetriever
{
    /** @var string[] */
    protected array $featureFilter = [];

    /** @var string[] */
    protected array $mealFilter = [];

    /** @var string[] */
    protected array $freeFromFilter = [];

    /**
     * @param array{features?: string[], meals?: string[], freeFrom?: string[]} $filters
     * @return array{recipes: Closure, features: Closure, meals: Closure, freeFrom: Closure, setFilters: Closure}
     */
    public function getData(array $filters = []): array
    {
        $this->featureFilter = array_filter($filters['features'] ?? []);
        $this->mealFilter = array_filter($filters['meals'] ?? []);
        $this->freeFromFilter = array_filter($filters['freeFrom'] ?? []);

        return [
            'recipes' => fn () => $this->getRecipes(),
            'features' => fn () => $this->getFeatures(),
            'meals' => fn () => $this->getMeals(),
            'freeFrom' => fn () => $this->getFreeFrom(),
            'setFilters' => fn () => [
                'features' => $this->featureFilter,
                'meals' => $this->mealFilter,
                'freeFrom' => $this->freeFromFilter,
            ],
        ];
    }

    /**
     * @param Builder<Recipe> $builder
     */
    protected function filterRecipeFeatures(Builder $builder): void
    {
        foreach ($this->featureFilter as $feature) {
            $builder->whereHas('features', fn (Builder $builder) => $builder->where('slug', $feature));
        }
    }

    /**
     * @param Builder<Recipe> $builder
     */
    protected function filterRecipeMeals(Builder $builder): void
    {
        foreach ($this->mealFilter as $meal) {
            $builder->whereHas('meals', fn (Builder $builder) => $builder->where('slug', $meal));
        }
    }

    /**
     * @param Builder<Recipe> $builder
     */
    protected function filterRecipeFreeFrom(Builder $builder): void
    {
        foreach ($this->freeFromFilter as $allergen) {
            $builder->whereHas('allergens', fn (Builder $builder) => $builder->where('slug', $allergen));
        }
    }

    protected function getRecipes(): RecipeListCollection
    {
        return new RecipeListCollection(
            Recipe::query()
                ->with(['media', 'features', 'nutrition'])
                ->when(count($this->featureFilter) > 0, $this->filterRecipeFeatures(...))
                ->when(count($this->mealFilter) > 0, $this->filterRecipeMeals(...))
                ->when(count($this->freeFromFilter) > 0, $this->filterRecipeFreeFrom(...))
                ->latest()
                ->paginate(12)
                ->withQueryString()
        );
    }

    protected function getRecipeCount(): array
    {
        return ['recipes' => function (Builder $builder): void {
            $builder->when(count($this->featureFilter) > 0, $this->filterRecipeFeatures(...))
                ->when(count($this->mealFilter) > 0, $this->filterRecipeMeals(...))
                ->when(count($this->freeFromFilter) > 0, $this->filterRecipeFreeFrom(...));
        }];
    }

    /** @return Collection<int, array> */
    protected function getFeatures(): Collection
    {
        return RecipeFeature::query()
            ->when(count($this->featureFilter) > 0, function (Builder $builder): void {
                $builder->whereHas('recipes', $this->filterRecipeFeatures(...));
            })
            ->when(count($this->mealFilter) > 0, function (Builder $builder): void {
                $builder->whereHas('recipes', $this->filterRecipeMeals(...));
            })
            ->when(count($this->freeFromFilter) > 0, function (Builder $builder): void {
                $builder->whereHas('recipes', $this->filterRecipeFreeFrom(...));
            })
            ->withCount($this->getRecipeCount())
            ->orderBy('feature')
            ->get()
            ->map(fn (RecipeFeature $feature) => $feature->only(['feature', 'slug', 'recipes_count']));
    }

    /** @return Collection<int, array> */
    protected function getMeals(): Collection
    {
        return RecipeMeal::query()
            ->when(count($this->featureFilter) > 0, function (Builder $builder): void {
                $builder->whereHas('recipes', $this->filterRecipeFeatures(...));
            })
            ->when(count($this->mealFilter) > 0, function (Builder $builder): void {
                $builder->whereHas('recipes', $this->filterRecipeMeals(...));
            })
            ->when(count($this->freeFromFilter) > 0, function (Builder $builder): void {
                $builder->whereHas('recipes', $this->filterRecipeFreeFrom(...));
            })
            ->withCount($this->getRecipeCount())
            ->get()
            ->map(fn (RecipeMeal $feature) => $feature->only(['meal', 'slug', 'recipes_count']));
    }

    /** @return Collection<int, array> */
    protected function getFreeFrom(): Collection
    {
        return RecipeAllergen::query()
            ->when(count($this->featureFilter) > 0, function (Builder $builder): void {
                $builder->whereHas('recipes', $this->filterRecipeFeatures(...));
            })
            ->when(count($this->mealFilter) > 0, function (Builder $builder): void {
                $builder->whereHas('recipes', $this->filterRecipeMeals(...));
            })
            ->when(count($this->freeFromFilter) > 0, function (Builder $builder): void {
                $builder->whereHas('recipes', $this->filterRecipeFreeFrom(...));
            })
            ->withCount($this->getRecipeCount())
            ->orderBy('allergen')
            ->get()
            ->map(fn (RecipeAllergen $feature) => $feature->only(['allergen', 'slug', 'recipes_count']));
    }
}
