<?php

declare(strict_types=1);

namespace App\Modules\Recipe\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property string $icon
 * @property int $id
 * @property string $feature
 */
class RecipeFeature extends Model
{
    protected $appends = ['image'];

    protected $visible = [
        'id',
        'feature',
        'image',
    ];

    public function getImageAttribute(): string
    {
        return asset('assets/images/recipe-features/' . $this->icon . '.png');
    }

    /** @return BelongsToMany<Recipe> */
    public function recipes(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class, 'recipe_assigned_features', 'recipe_id', 'feature_type_id');
    }
}
