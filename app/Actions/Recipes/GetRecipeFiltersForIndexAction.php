<?php

declare(strict_types=1);

namespace App\Actions\Recipes;

use App\Contracts\Recipes\FilterableRecipeRelation;
use App\Models\Recipes\Recipe;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class GetRecipeFiltersForIndexAction
{
    /**
     * @template TFilter of FilterableRecipeRelation
     * @param class-string<TFilter> $relation
     * @param array{features?: string[], meals?: string[], freeFrom?: string[]} $filters
     * @return Collection<int, array>
     */
    public function __invoke(string $relation, array $filters = []): Collection
    {
        $featureFilters = array_filter($filters['features'] ?? []);
        $mealFilters = array_filter($filters['meals'] ?? []);
        $freeFromFilters = array_filter($filters['freeFrom'] ?? []);

        /** @var Builder<TFilter> $query */
        $query = $relation::query(); /** @phpstan-ignore-line */

        if (count($featureFilters) > 0) {
            $query->hasRecipesWithFeatures($featureFilters);
        }

        if (count($mealFilters) > 0) {
            $query->hasRecipesWithMeals($mealFilters);
        }

        if (count($freeFromFilters) > 0) {
            $query->hasRecipesWithFreeFrom($freeFromFilters);
        }

        /** @var Builder<TFilter> $query */
        $query = $query->withCount(['recipes' => function (Builder $builder) use ($featureFilters, $mealFilters, $freeFromFilters): Builder { /** @phpstan-ignore-line */
            /** @var Builder<Recipe> $builder */

            if (count($featureFilters) > 0) {
                $builder->hasFeatures($featureFilters);
            }

            if (count($mealFilters) > 0) {
                $builder->hasMeals($mealFilters);
            }

            if (count($freeFromFilters) > 0) {
                $builder->hasFreeFrom($freeFromFilters);
            }

            return $builder;
        }]);

        $column = Str::of(class_basename($relation))->after('Recipe')->lower()->toString();

        return $query
            ->orderBy($column)
            ->get()
            ->map(fn (FilterableRecipeRelation $relation) => $relation->only([$column, 'slug', 'recipes_count']));
    }
}
