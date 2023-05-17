<?php

declare(strict_types=1);

namespace Tests;

use App\Modules\Blog\Models\Blog;
use App\Modules\Blog\Models\BlogTag;
use App\Modules\Collection\Models\Collection;
use App\Modules\Recipe\Models\Recipe;
use App\Modules\Recipe\Models\RecipeAllergen;
use App\Modules\Recipe\Models\RecipeFeature;
use App\Modules\Recipe\Models\RecipeMeal;
use App\Modules\Recipe\Models\RecipeNutrition;
use Carbon\Carbon;
use Database\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Factory as IlluminateFactory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use LazilyRefreshDatabase;

    protected function migrateUsing(): array
    {
        return [
            '--schema-path' => 'database/schema/mysql-schema.dump'
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();

        DB::connection()->getSchemaBuilder()->disableForeignKeyConstraints();

        $this->afterApplicationCreated(fn () => $this->seed());
    }

    /**
     * @template T
     *
     * @param class-string<T> $what
     * @return IlluminateFactory<T>
     */
    protected function build(string $what): IlluminateFactory
    {
        return Factory::factoryForModel($what);
    }

    /**
     * @template T
     *
     * @param class-string<T> $what
     * @param array $attributes
     * @return T
     */
    protected function create(string $what, array $attributes = [])
    {
        return $this->build($what)->create($attributes);
    }

    /** @param class-string<ServiceProvider> $serviceProvider */
    public function assertServiceProviderLoaded(string $serviceProvider): void
    {
        $this->assertArrayHasKey($serviceProvider, $this->app->getLoadedProviders());
    }

    /** @param class-string<ServiceProvider> $serviceProvider */
    public function assertServiceProviderNotLoaded(string $serviceProvider): void
    {
        $this->assertArrayNotHasKey($serviceProvider, $this->app->getLoadedProviders());
    }

    protected function withBlogs($count = 10, callable $then = null): static
    {
        Storage::fake('media');

        $this->build(Blog::class)
            ->count($count)
            ->sequence(fn (Sequence $sequence) => [
                'id' => $sequence->index+1,
                'title' => "Blog {$sequence->index}",
                'created_at' => Carbon::now()->subDays($sequence->index)
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
                'created_at' => Carbon::now()->subDays($sequence->index)
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
                'id' => $sequence->index+1,
                'title' => "Collection {$sequence->index}",
                'created_at' => Carbon::now()->subDays($sequence->index)
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
