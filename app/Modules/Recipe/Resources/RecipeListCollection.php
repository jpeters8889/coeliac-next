<?php

declare(strict_types=1);

namespace App\Modules\Recipe\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class RecipeListCollection extends ResourceCollection
{
    public $collects = RecipeDetailCardViewResource::class;
}
