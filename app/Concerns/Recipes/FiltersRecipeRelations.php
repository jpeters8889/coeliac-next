<?php

declare(strict_types=1);

namespace App\Concerns\Recipes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends Model<FiltersRecipeRelations>
 */
trait FiltersRecipeRelations
{
    /**
     * @param Builder<self> $query
     * @return Builder<self>
     */
    public function scopeHasRecipesWithFeatures(Builder $query, array $features): Builder
    {
        /** @phpstan-ignore-next-line */
        return $query->whereHas('recipes', fn (Builder $builder) => $builder->hasFeatures($features));
    }

    /**
     * @param Builder<self> $query
     * @return Builder<self>
     */
    public function scopeHasRecipesWithMeals(Builder $query, array $meals): Builder
    {
        /** @phpstan-ignore-next-line */
        return $query->whereHas('recipes', fn (Builder $builder) => $builder->hasMeals($meals));
    }

    /**
     * @param Builder<self> $query
     * @return Builder<self>
     */
    public function scopeHasRecipesWithFreeFrom(Builder $query, array $freeFrom): Builder
    {
        /** @phpstan-ignore-next-line */
        return $query->whereHas('recipes', fn (Builder $builder) => $builder->hasFreeFrom($freeFrom));
    }
}
