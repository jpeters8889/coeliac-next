<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Recipe\Http;

use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class RecipeListTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('media');

        $this->withRecipes(30);
    }

    /** @test */
    public function itLoadsTheRecipeListPage(): void
    {
        $this->get(route('recipe.index'))->assertOk();
    }

    /** @test */
    public function itReturnsTheFirst12Recipes(): void
    {
        $this->get(route('recipe.index'))
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('Recipe/Index')
                    ->has('recipes')
                    ->has(
                        'recipes.data',
                        12,
                        fn (Assert $page) => $page
                            ->hasAll(['title', 'description', 'date', 'image', 'square_image', 'link', 'description', 'features', 'nutrition'])
                    )
                    ->where('recipes.data.0.title', 'Recipe 0')
                    ->where('recipes.data.1.title', 'Recipe 1')
                    ->has('recipes.links')
                    ->has('recipes.meta')
                    ->where('recipes.meta.current_page', 1)
                    ->where('recipes.meta.per_page', 12)
                    ->where('recipes.meta.total', 30)
                    ->etc()
            );
    }

    /** @test */
    public function itCanLoadOtherPages(): void
    {
        $this->get(route('recipe.index', ['page' => 2]))
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('Recipe/Index')
                    ->has('recipes')
                    ->has(
                        'recipes.data',
                        12,
                        fn (Assert $page) => $page
                            ->hasAll(['title', 'description', 'date', 'image', 'square_image', 'link', 'description', 'features', 'nutrition'])
                    )
                    ->where('recipes.data.0.title', 'Recipe 12')
                    ->where('recipes.data.1.title', 'Recipe 13')
                    ->has('recipes.links')
                    ->has('recipes.meta')
                    ->where('recipes.meta.current_page', 2)
                    ->where('recipes.meta.per_page', 12)
                    ->where('recipes.meta.total', 30)
                    ->etc()
            );
    }
}
