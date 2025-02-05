<?php

declare(strict_types=1);

namespace App\Models\Recipes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecipeNutrition extends Model
{
    protected $hidden = ['id', 'created_at', 'updated_at'];

    /** @return BelongsTo<Recipe, $this> */
    public function recipe(): BelongsTo
    {
        return $this->belongsTo(Recipe::class);
    }
}
