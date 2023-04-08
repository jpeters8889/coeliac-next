<?php

declare(strict_types=1);

namespace App\Modules\Recipe\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $meal
 * @property null | int $recipes_count
 */
class RecipeMeal extends Model
{
    /** @return BelongsToMany<Recipe> */
    public function recipes(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class, 'recipe_assigned_meals', 'meal_type_id', 'recipe_id');
    }
}
