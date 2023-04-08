<?php

declare(strict_types=1);

namespace App\Modules\Recipe\Http\Controllers;

use App\Http\Response\Inertia;
use App\Modules\Recipe\Support\RecipeIndexDataRetriever;
use Inertia\Response;

class RecipeController
{
    public function index(Inertia $inertia, RecipeIndexDataRetriever $recipeDataRetriever): Response
    {
        return $inertia
            ->title('Gluten Free Recipes')
            ->metaDescription('Coeliac Sanctuary gluten free recipe list, all of our fabulous gluten free recipes which I have been tried and tested! ')
            ->metaTags(['coeliac sanctuary recipes', 'recipe index', 'recipe list', 'gluten free recipes', 'recipes', 'coeliac recipes'])
            ->render('Recipe/Index', $recipeDataRetriever->getData());
    }
}
