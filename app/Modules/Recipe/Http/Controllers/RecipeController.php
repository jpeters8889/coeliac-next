<?php

declare(strict_types=1);

namespace App\Modules\Recipe\Http\Controllers;

use App\Http\Response\Inertia;
use App\Modules\Recipe\Models\Recipe;
use App\Modules\Recipe\Resources\RecipeShowResource;
use App\Modules\Recipe\Support\RecipeIndexDataRetriever;
use App\Modules\Shared\Comments\Resources\CommentCollection;
use Illuminate\Http\Request;
use Inertia\Response;

class RecipeController
{
    public function index(Inertia $inertia, RecipeIndexDataRetriever $recipeDataRetriever, Request $request): Response
    {
        return $inertia
            ->title('Gluten Free Recipes')
            ->metaDescription('Coeliac Sanctuary gluten free recipe list, all of our fabulous gluten free recipes which I have been tried and tested! ')
            ->metaTags(['coeliac sanctuary recipes', 'recipe index', 'recipe list', 'gluten free recipes', 'recipes', 'coeliac recipes'])
            ->render('Recipe/Index', $recipeDataRetriever->getData([
                'features' => explode(',', (string)$request->string('features', '')),
                'meals' => explode(',', (string)$request->string('meals', '')),
                'freeFrom' => explode(',', (string)$request->string('freeFrom', '')),
            ]));
    }

    public function show(Recipe $recipe, Inertia $inertia): Response
    {
        return $inertia
            ->title($recipe->title)
            ->metaDescription($recipe->meta_description)
            ->metaTags(explode(',', $recipe->meta_tags))
            ->metaImage($recipe->social_image)
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
                'comments' => fn () => new CommentCollection(
                  $recipe->comments()
                  ->with('reply')
                  ->simplePaginate(5, pageName: 'commentPage')
                ),
            ]);
    }
}
