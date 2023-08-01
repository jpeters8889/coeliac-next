<?php

declare(strict_types=1);

namespace App\Models\Recipes;

use App\Concerns\Recipes\FiltersRecipeRelations;
use App\Contracts\Recipes\FilterableRecipeRelation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property string $id
 * @property string $allergen
 * @property null | int $recipes_count
 * @property string $slug
 *
 * @implements  FilterableRecipeRelation<RecipeAllergen>
 */
class RecipeAllergen extends Model implements FilterableRecipeRelation
{
    use FiltersRecipeRelations;

    /** @return BelongsToMany<Recipe> */
    public function recipes(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class, 'recipe_assigned_allergens', 'allergen_type_id', 'recipe_id');
    }
}