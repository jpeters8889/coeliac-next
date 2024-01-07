<?php

declare(strict_types=1);

namespace App\Http\Controllers\Recipes;

use App\Actions\Recipes\GetRecipeFiltersForIndexAction;
use App\Actions\Recipes\GetRecipesForIndexAction;
use App\Http\Response\Inertia;
use App\Models\Recipes\Recipe;
use App\Models\Recipes\RecipeAllergen;
use App\Models\Recipes\RecipeFeature;
use App\Models\Recipes\RecipeMeal;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Inertia\Response;

class RecipeIndexController
{
    public function __invoke(
        Inertia $inertia,
        Request $request,
        GetRecipesForIndexAction $getRecipesForIndexAction,
        GetRecipeFiltersForIndexAction $getRecipeFiltersForIndexAction
    ): Response {
        /** @var array{filters: string[], meals: string[], freeFrom: string[]} $filters */
        $filters = [
            'features' => $request->string('features', '')->explode(',')->filter()->toArray(),
            'meals' => $request->string('meals', '')->explode(',')->filter()->toArray(),
            'freeFrom' => $request->string('freeFrom', '')->explode(',')->filter()->toArray(),
        ];

        return $inertia
            ->title('Gluten Free Recipes')
            ->metaDescription('Coeliac Sanctuary gluten free recipe list, all of our fabulous gluten free recipes which I have been tried and tested! ')
            ->metaTags(['coeliac sanctuary recipes', 'recipe index', 'recipe list', 'gluten free recipes', 'recipes', 'coeliac recipes'])
            ->render('Recipe/Index', [
                'recipes' => fn () => $getRecipesForIndexAction->handle($filters),
                'features' => fn () => $getRecipeFiltersForIndexAction->handle(RecipeFeature::class, $filters),
                'meals' => fn () => $getRecipeFiltersForIndexAction->handle(RecipeMeal::class, $filters),
                'freeFrom' => fn () => $getRecipeFiltersForIndexAction->handle(RecipeAllergen::class, $filters),
                'setFilters' => fn () => $filters,
            ]);
    }

    public function print(Recipe $recipe): View
    {
        return view('recipe-print', ['recipe' => $recipe]);
    }
}