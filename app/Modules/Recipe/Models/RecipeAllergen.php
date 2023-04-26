<?php

declare(strict_types=1);

namespace App\Modules\Recipe\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property string $id
 * @property string $allergen
 * @property null | int $recipes_count
 * @property string $slug
 */
class RecipeAllergen extends Model
{
    /** @return BelongsToMany<Recipe> */
    public function recipes(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class, 'recipe_assigned_allergens', 'allergen_type_id', 'recipe_id');
    }
}
