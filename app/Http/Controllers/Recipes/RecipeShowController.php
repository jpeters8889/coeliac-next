<?php

declare(strict_types=1);

namespace App\Http\Controllers\Recipes;

use App\Actions\Comments\GetCommentsForItemAction;
use App\Http\Response\Inertia;
use App\Models\Recipes\Recipe;
use App\Resources\Recipes\RecipeShowResource;
use Illuminate\Contracts\View\View;
use Inertia\Response;

class RecipeShowController
{
    public function __invoke(Recipe $recipe, Inertia $inertia, GetCommentsForItemAction $getCommentsForItemAction): Response
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
                'comments' => fn () => $getCommentsForItemAction->handle($recipe),
            ]);
    }

    public function print(Recipe $recipe): View
    {
        return view('recipe-print', ['recipe' => $recipe]);
    }
}
