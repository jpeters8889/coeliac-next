<?php

declare(strict_types=1);

namespace App\Actions\Recipes;

use App\Models\Recipes\Recipe;
use App\Resources\Recipes\RecipeSimpleCardViewResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

class GetLatestRecipesForHomepageAction
{
    public function __invoke(): AnonymousResourceCollection
    {
        /** @var string $key */
        $key = config('coeliac.cache.recipes.home');

        return Cache::rememberForever(
            $key,
            fn () => RecipeSimpleCardViewResource::collection(Recipe::query()
                ->take(8)
                ->latest()
                ->with(['media'])
                ->get())
        );
    }
}
