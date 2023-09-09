<?php

declare(strict_types=1);

namespace Tests\Concerns;

use App\Models\Blogs\Blog;
use App\Models\Blogs\BlogTag;
use App\Models\Collections\Collection;
use App\Models\Recipes\Recipe;
use App\Models\Recipes\RecipeAllergen;
use App\Models\Recipes\RecipeFeature;
use App\Models\Recipes\RecipeMeal;
use App\Models\Recipes\RecipeNutrition;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/** @mixin TestCase */
trait SeedsWebsite
{
    protected function withBlogs($count = 10, callable $then = null): static
    {
        Storage::fake('media');

        $this->build(Blog::class)
            ->count($count)
            ->sequence(fn (Sequence $sequence) => [
                'id' => $sequence->index + 1,
                'title' => "Blog {$sequence->index}",
                'created_at' => Carbon::now()->subDays($sequence->index),
            ])
            ->has($this->build(BlogTag::class)->count(3), 'tags')
            ->create()
            ->each(function (Blog $blog): void {
                $blog->addMedia(UploadedFile::fake()->image('blog.jpg'))->toMediaCollection('primary');
                $blog->addMedia(UploadedFile::fake()->image('blog.jpg'))->toMediaCollection('social');
            });

        if ($then) {
            $then();
        }

        return $this;
    }

    protected function withRecipes($count = 10, callable $then = null): static
    {
        Storage::fake('media');

        $this->build(Recipe::class)
            ->count($count)
            ->sequence(fn (Sequence $sequence) => [
                'id' => $sequence->index + 1,
                'title' => "Recipe {$sequence->index}",
                'created_at' => Carbon::now()->subDays($sequence->index),
            ])
            ->has($this->build(RecipeFeature::class), 'features')
            ->has($this->build(RecipeAllergen::class), 'allergens')
            ->has($this->build(RecipeMeal::class), 'meals')
            ->has($this->build(RecipeNutrition::class), 'nutrition')
            ->create()
            ->each(function (Recipe $recipe): void {
                $recipe->addMedia(UploadedFile::fake()->image('recipe.jpg'))->toMediaCollection('primary');
                $recipe->addMedia(UploadedFile::fake()->image('recipe.jpg'))->toMediaCollection('social');
            });

        if ($then) {
            $then();
        }

        return $this;
    }

    protected function withCollections($count = 10, callable $then = null): static
    {
        Storage::fake('media');

        $this->build(Collection::class)
            ->count($count)
            ->sequence(fn (Sequence $sequence) => [
                'id' => $sequence->index + 1,
                'title' => "Collection {$sequence->index}",
                'created_at' => Carbon::now()->subDays($sequence->index),
            ])
            ->create()
            ->each(function (Collection $collection): void {
                $collection->addMedia(UploadedFile::fake()->image('collection.jpg'))->toMediaCollection('primary');
                $collection->addMedia(UploadedFile::fake()->image('collection.jpg'))->toMediaCollection('social');
            });

        if ($then) {
            $then();
        }

        return $this;
    }
}
