<?php

declare(strict_types=1);

namespace App\Resources\Recipes;

use Illuminate\Http\Resources\Json\ResourceCollection;

class RecipeListCollection extends ResourceCollection
{
    public $collects = RecipeDetailCardViewResource::class;
}
