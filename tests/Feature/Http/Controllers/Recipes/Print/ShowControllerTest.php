<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Recipes\Print;

use PHPUnit\Framework\Attributes\Test;
use App\Models\Recipes\Recipe;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class ShowControllerTest extends TestCase
{
    protected Recipe $recipe;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withRecipes(1);

        $this->recipe = Recipe::query()->first();
    }

    #[Test]
    public function itReturnsNotFoundForARecipeDoesntExist(): void
    {
        $this->get(route('recipe.print', ['recipe' => 'foobar']))->assertNotFound();
    }

    protected function visitRecipe(): TestResponse
    {
        return $this->get(route('recipe.print', ['recipe' => $this->recipe]));
    }

    #[Test]
    public function itReturnsNotFoundForARecipeThatIsntLive(): void
    {
        $this->recipe->update(['live' => false]);

        $this->visitRecipe()->assertNotFound();
    }

    #[Test]
    public function itRendersTheInertiaPage(): void
    {
        $this
            ->visitRecipe()
            ->assertOk()
            ->assertViewIs('recipe-print');
    }
}
