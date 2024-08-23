<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Recipes;

use App\Jobs\OpenGraphImages\CreateHomePageOpenGraphImageJob;
use App\Jobs\OpenGraphImages\CreateRecipeIndexPageOpenGraphImageJob;
use App\Models\Recipes\Recipe;
use App\Models\Recipes\RecipeAllergen;
use App\Models\Recipes\RecipeFeature;
use App\Models\Recipes\RecipeMeal;
use App\Models\Recipes\RecipeNutrition;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Bus;
use Tests\Concerns\CanBePublishedTestTrait;
use Tests\Concerns\CommentableTestTrait;
use Tests\Concerns\DisplaysMediaTestTrait;
use Tests\Concerns\LinkableModelTestTrait;
use Tests\TestCase;

class RecipeModelTest extends TestCase
{
    use CanBePublishedTestTrait;
    use CommentableTestTrait;
    use DisplaysMediaTestTrait;
    use LinkableModelTestTrait;

    protected Recipe $recipe;

    public function setUp(): void
    {
        parent::setUp();

        $this->recipe = $this->build(Recipe::class)
            ->has($this->build(RecipeFeature::class), 'features')
            ->has($this->build(RecipeAllergen::class), 'allergens')
            ->has($this->build(RecipeMeal::class), 'meals')
            ->has($this->build(RecipeNutrition::class), 'nutrition')
            ->create();

        $this->setUpDisplaysMediaTest(fn () => $this->create(Recipe::class));

        $this->setUpLinkableModelTest(fn (array $params) => $this->create(Recipe::class, $params));

        $this->setUpCommentsTest(fn (array $params = []) => $this->create(Recipe::class, $params));

        $this->setUpCanBePublishedModelTest(fn (array $params = []) => $this->create(Recipe::class, $params));

        $this->item->addMedia(UploadedFile::fake()->image('square.jpg'))->toMediaCollection('square');
    }

    /** @test */
    public function itDispatchesTheCreateOpenGraphImageJobWhenSaved(): void
    {
        config()->set('coeliac.generate_og_images', true);

        Bus::fake();

        $this->create(Recipe::class);

        Bus::assertDispatched(CreateRecipeIndexPageOpenGraphImageJob::class);
        Bus::assertDispatched(CreateHomePageOpenGraphImageJob::class);
    }

    /** @test */
    public function itHasAFeature(): void
    {
        $this->assertEquals(1, $this->recipe->features()->count());
    }

    /** @test */
    public function itHasAnAllergen(): void
    {
        $this->assertEquals(1, $this->recipe->allergens->count());
    }

    /** @test */
    public function itHasAMealType(): void
    {
        $this->assertEquals(1, $this->recipe->meals->count());
    }

    /** @test */
    public function itHasNutrition(): void
    {
        $this->assertEquals(1, $this->recipe->nutrition->count());
    }

    /** @test */
    public function itCanGetTheSquareImage(): void
    {
        $squareImage = $this->item->square_image;

        $this->assertNotNull($squareImage);
        $this->assertStringContainsString('square.jpg', $squareImage);
    }
}
