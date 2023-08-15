<?php

declare(strict_types=1);

namespace App\Actions\Recipes;

use App\Models\Recipes\Recipe;
use App\Resources\Recipes\RecipeListCollection;
use Illuminate\Database\Eloquent\Builder;

class GetRecipesForIndexAction
{
    /** @param  array{features?: string[], meals?: string[], freeFrom?: string[]}  $filters */
    public function handle(array $filters = [], int $perPage = 12): RecipeListCollection
    {
        $featureFilters = array_filter($filters['features'] ?? []);
        $mealFilters = array_filter($filters['meals'] ?? []);
        $freeFromFilters = array_filter($filters['freeFrom'] ?? []);

        /** @var Builder<Recipe> $query */
        $query = Recipe::query()->with(['media', 'features', 'nutrition']);

        if (count($featureFilters) > 0) {
            $query->hasFeatures($featureFilters);
        }

        if (count($mealFilters) > 0) {
            $query->hasMeals($mealFilters);
        }

        if (count($freeFromFilters) > 0) {
            $query->hasFreeFrom($freeFromFilters);
        }

        return new RecipeListCollection(
            $query
                ->latest()
                ->paginate($perPage)
                ->withQueryString()
        );
    }
}
