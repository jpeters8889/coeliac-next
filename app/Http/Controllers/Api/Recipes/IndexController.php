<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Recipes;

use App\Actions\Recipes\GetRecipesForIndexAction;
use App\Resources\Recipes\RecipeApiCollection;

class IndexController
{
    public function __invoke(GetRecipesForIndexAction $getRecipesForIndexAction): RecipeApiCollection
    {
        return $getRecipesForIndexAction->handle(resource: RecipeApiCollection::class);
    }
}
