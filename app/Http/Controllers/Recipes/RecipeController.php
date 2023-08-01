<?php

declare(strict_types=1);

namespace App\Http\Controllers\Recipes;

use App\Actions\Comments\GetCommentsForItemAction;
use App\Actions\Recipes\GetRecipeFiltersForIndexAction;
use App\Actions\Recipes\GetRecipesForIndexAction;
use App\Http\Response\Inertia;
use App\Models\Recipes\Recipe;
use App\Models\Recipes\RecipeAllergen;
use App\Models\Recipes\RecipeFeature;
use App\Models\Recipes\RecipeMeal;
use App\Resources\Recipes\RecipeShowResource;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Inertia\Response;

class RecipeController
{
    public function index(
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
                'recipes' => fn () => $getRecipesForIndexAction($filters),
                'features' => fn () => $getRecipeFiltersForIndexAction(RecipeFeature::class, $filters),
                'meals' => fn () => $getRecipeFiltersForIndexAction(RecipeMeal::class, $filters),
                'freeFrom' => fn () => $getRecipeFiltersForIndexAction(RecipeAllergen::class, $filters),
                'setFilters' => fn () => $filters,
            ]);
    }

    public function show(Recipe $recipe, Inertia $inertia, GetCommentsForItemAction $getCommentsForItemAction): Response
    {
        return $inertia
            ->title($recipe->title)
            ->metaDescription($recipe->meta_description)
            ->metaTags(explode(',', $recipe->meta_tags))
            ->metaImage($recipe->social_image)
            ->schema($recipe->schema()->toScript())
            ->alternateMetas([
                'article:publisher' => 'https://www.facebook.com/coeliacsanctuary',
                'article:section' => 'Food',
                'article:published_time' => $recipe->created_at,
                'article:modified_time' => $recipe->updated_at,
                'article:author' => 'Coeliac Sanctuary',
                'article.tags' => $recipe->meta_tags,
            ])
            ->render('Recipe/Show', [
                'recipe' => new RecipeShowResource($recipe),
                'comments' => fn () => $getCommentsForItemAction($recipe),
            ]);
    }

    public function print(Recipe $recipe): View
    {
        return view('recipe-print', ['recipe' => $recipe]);
    }
}
