<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\Recipes;

use App\Actions\Recipes\GetRecipesForIndexAction;
use App\Resources\Recipes\RecipeApiCollection;
use Tests\TestCase;

class IndexControllerTest extends TestCase
{
    /** @test */
    public function itCallsTheGetRecipesForRecipeIndexAction(): void
    {
        $this->expectAction(GetRecipesForIndexAction::class, return: RecipeApiCollection::make(collect()));

        $this->get(route('api.recipes.index'))->assertOk();
    }
}
