<?php

declare(strict_types=1);

namespace App\Nova\Resources\Main;

use App\Models\Recipes\RecipeAllergen;
use App\Nova\Resource;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Http\Requests\NovaRequest;

/** @extends Resource<RecipeAllergen> */
/**
 * @codeCoverageIgnore
 */
class RecipeAllergens extends Resource
{
    public static string $model = RecipeAllergen::class;

    public function fields(NovaRequest $request)
    {
        return RecipeAllergen::query()
            ->get()
            ->map(fn (RecipeAllergen $allergen) => Boolean::make(Str::title($allergen->allergen))->default(true))
            ->toArray();
    }
}
