<?php

declare(strict_types=1);

namespace App\Modules\Recipe\Support;

use App\Modules\Recipe\Models\Recipe;
use App\Modules\Recipe\Models\RecipeAllergen;
use App\Modules\Recipe\Models\RecipeFeature;
use App\Modules\Recipe\Models\RecipeMeal;
use App\Modules\Recipe\Resources\RecipeListCollection;
use Closure;
use Illuminate\Support\Collection;

class RecipeIndexDataRetriever
{
    /** @return array{recipes: Closure, features: Closure, meals: Closure, freeFrom: Closure} */
    public function getData(): array
    {
        return [
            'recipes' => fn () => $this->getRecipes(),
            'features' => fn () => $this->getFeatures(),
            'meals' => fn () => $this->getMeals(),
            'freeFrom' => fn () => $this->getFreeFrom(),
        ];
    }

    protected function getRecipes(): RecipeListCollection
    {
        return new RecipeListCollection(
            Recipe::query()
                ->with(['media', 'features', 'nutrition'])
                ->latest()
                ->paginate(12)
        );
    }

    /** @return Collection<int, array> */
    protected function getFeatures(): Collection
    {
        return RecipeFeature::query()
            ->withCount(['recipes'])
            ->orderBy('feature')
            ->get()
            ->map(fn (RecipeFeature $feature) => $feature->only(['feature', 'slug', 'recipes_count']));
    }

    /** @return Collection<int, array> */
    protected function getMeals(): Collection
    {
        return RecipeMeal::query()
            ->withCount(['recipes'])
            ->get()
            ->map(fn (RecipeMeal $feature) => $feature->only(['meal', 'slug', 'recipes_count']));
    }

    /** @return Collection<int, array> */
    protected function getFreeFrom(): Collection
    {
        return RecipeAllergen::query()
            ->withCount(['recipes'])
            ->orderBy('allergen')
            ->get()
            ->map(fn (RecipeAllergen $feature) => $feature->only(['allergen', 'slug', 'recipes_count']));
    }
}
