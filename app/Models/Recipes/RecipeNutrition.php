<?php

declare(strict_types=1);

namespace App\Models\Recipes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $calories
 * @property mixed  $carbs
 * @property mixed  $fat
 * @property mixed  $protein
 * @property mixed  $sugar
 * @property mixed  $fibre
 */
class RecipeNutrition extends Model
{
    protected $hidden = ['id', 'created_at', 'updated_at'];

    /** @return BelongsTo<Recipe, RecipeNutrition> */
    public function recipe(): BelongsTo
    {
        return $this->belongsTo(Recipe::class);
    }
}
