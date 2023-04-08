<?php

declare(strict_types=1);

namespace App\Modules\Recipe\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property string $icon
 * @property int $id
 * @property string $feature
 * @property null | int $recipes_count
 */
class RecipeFeature extends Model
{
    /** @return BelongsToMany<Recipe> */
    public function recipes(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class, 'recipe_assigned_features', 'feature_type_id', 'recipe_id');
    }
}
