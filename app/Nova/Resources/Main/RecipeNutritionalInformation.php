<?php

declare(strict_types=1);

namespace App\Nova\Resources\Main;

use App\Models\Recipes\RecipeNutrition;
use App\Nova\Resource;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Http\Requests\NovaRequest;

/** @extends Resource<RecipeNutrition> */
/**
 * @codeCoverageIgnore
 */
class RecipeNutritionalInformation extends Resource
{
    public static string $model = RecipeNutrition::class;

    public function fields(NovaRequest $request)
    {
        return [
            Number::make('Calories')->rules(['required'])->fullWidth(),
            Number::make('Carbs')->rules(['required'])->fullWidth(),
            Number::make('Fat')->rules(['required'])->fullWidth(),
            Number::make('Protein')->rules(['required'])->fullWidth(),
            Number::make('Fibre')->rules(['required'])->fullWidth(),
            Number::make('Sugar')->rules(['required'])->fullWidth(),
        ];
    }
}
