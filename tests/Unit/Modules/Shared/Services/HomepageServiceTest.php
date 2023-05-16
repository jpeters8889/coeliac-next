<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Shared\Services;

use App\Modules\Blog\Models\Blog;
use App\Modules\Blog\Resources\BlogSimpleCardViewResource;
use App\Modules\Collection\Models\Collection;
use App\Modules\Collection\Resources\CollectedItemSimpleCardViewResource;
use App\Modules\Collection\Resources\CollectionSimpleCardViewResource;
use App\Modules\Recipe\Models\Recipe;
use App\Modules\Recipe\Resources\RecipeSimpleCardViewResource;
use App\Modules\Shared\Services\HomepageService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HomepageServiceTest extends TestCase
{
    protected HomepageService $service;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('media');

        $this->service = resolve(HomepageService::class);

        $this->withBlogs();
        $this->withRecipes();
        $this->withCollections(2);
    }

    /** Blog Tests */

    /** @test */
    public function itCanReturnACollectionOfBlogs(): void
    {
        $this->assertInstanceOf(AnonymousResourceCollection::class, $this->service->blogs());
    }

    /** @test */
    public function itOnlyReturnsTheBlogAsACardResource(): void
    {
        $this->service->blogs()->each(function ($item): void {
            $this->assertInstanceOf(BlogSimpleCardViewResource::class, $item);
        });
    }

    /** @test */
    public function itReturnsSixBlogs(): void
    {
        $this->assertCount(6, $this->service->blogs());
    }

    /** @test */
    public function itReturnsTheLatestBlogsFirst(): void
    {
        $blogTitles = $this->service->blogs()->map(fn (BlogSimpleCardViewResource $blog) => $blog->title);

        $this->assertContains('Blog 0', $blogTitles);
        $this->assertContains('Blog 1', $blogTitles);
        $this->assertNotContains('Blog 9', $blogTitles);
    }

    /** @test */
    public function itDoesntReturnBlogsThatArentLive(): void
    {
        Blog::query()->first()->update(['live' => false]);

        $blogTitles = $this->service->blogs()->map(fn (BlogSimpleCardViewResource $blog) => $blog->title);

        $this->assertNotContains('Blog 0', $blogTitles);
        $this->assertContains('Blog 2', $blogTitles);
    }

    /** @test */
    public function itCachesTheBlogs(): void
    {
        $this->assertFalse(Cache::has(config('coeliac.cache.blogs.home')));

        $blogs = $this->service->blogs();

        $this->assertTrue(Cache::has(config('coeliac.cache.blogs.home')));
        $this->assertSame($blogs, Cache::get(config('coeliac.cache.blogs.home')));
    }

    /** @test */
    public function itLoadsTheBlogsFromTheCache(): void
    {
        DB::enableQueryLog();

        $this->service->blogs();

        // Blogs and media relation;
        $this->assertCount(2, DB::getQueryLog());

        $this->service->blogs();

        $this->assertCount(2, DB::getQueryLog());
    }

    /** Recipe Tests */

    /** @test */
    public function itCanReturnACollectionOfRecipes(): void
    {
        $this->assertInstanceOf(AnonymousResourceCollection::class, $this->service->recipes());
    }

    /** @test */
    public function itOnlyReturnsTheRecipeAsACardResource(): void
    {
        $this->service->recipes()->each(function ($item): void {
            $this->assertInstanceOf(RecipeSimpleCardViewResource::class, $item);
        });
    }

    /** @test */
    public function itReturnsEightRecipes(): void
    {
        $this->assertCount(8, $this->service->recipes());
    }

    /** @test */
    public function itReturnsTheLatestRecipesFirst(): void
    {
        $recipeTitles = $this->service->recipes()->map(fn (RecipeSimpleCardViewResource $recipe) => $recipe->title);

        $this->assertContains('Recipe 0', $recipeTitles);
        $this->assertContains('Recipe 1', $recipeTitles);
        $this->assertNotContains('Recipe 9', $recipeTitles);
    }

    /** @test */
    public function itDoesntReturnRecipesThatArentLive(): void
    {
        Recipe::query()->first()->update(['live' => false]);

        $recipeTitles = $this->service->recipes()->map(fn (RecipeSimpleCardViewResource $recipe) => $recipe->title);

        $this->assertNotContains('Recipe 0', $recipeTitles);
        $this->assertContains('Recipe 2', $recipeTitles);
    }

    /** @test */
    public function itCachesTheRecipes(): void
    {
        $this->assertFalse(Cache::has(config('coeliac.cache.recipes.home')));

        $recipes = $this->service->recipes();

        $this->assertTrue(Cache::has(config('coeliac.cache.recipes.home')));
        $this->assertSame($recipes, Cache::get(config('coeliac.cache.recipes.home')));
    }

    /** @test */
    public function itLoadsTheRecipesFromTheCache(): void
    {
        DB::enableQueryLog();

        $this->service->recipes();

        // Blogs and media relation;
        $this->assertCount(2, DB::getQueryLog());

        $this->service->recipes();

        $this->assertCount(2, DB::getQueryLog());
    }

    /** @test */
    public function itCanReturnACollectionOfCollections(): void
    {
        $this->assertInstanceOf(AnonymousResourceCollection::class, $this->service->collections());
    }

    /** @test */
    public function itDoesntLoadAnyCollectionsIfNoneAreSetToDisplayOnTheHomepage(): void
    {
        $this->assertCount(0, $this->service->collections());
    }

    /** @test */
    public function itReturnsTheCollectionsAsACardResource(): void
    {
        Collection::query()->update(['display_on_homepage' => true]);

        $this->service->collections()->each(function ($item): void {
            $this->assertInstanceOf(CollectionSimpleCardViewResource::class, $item);
        });
    }

    /** @test */
    public function itReturnsTheCollectedItemsWithTheCollectionResource(): void
    {
        /** @var Collection $collection */
        $collection = Collection::query()->first();

        $collection->update(['display_on_homepage' => true]);

        Blog::query()->take(3)->get()->each(function (Blog $blog) use ($collection): void {
            $collection->addItem($blog, $blog->description);
        });

        $collectionResource = $this->service->collections()[0]->toArray(request());

        $this->assertInstanceOf(AnonymousResourceCollection::class, $collectionResource['items']);

        $collectionResource['items']->each(function ($item): void {
            $this->assertInstanceOf(CollectedItemSimpleCardViewResource::class, $item);
        });
    }

    /** @test */
    public function itOnlyReturnsThreeCollectedItemsWithTheResource(): void
    {
        /** @var Collection $collection */
        $collection = Collection::query()->first();

        $collection->update(['display_on_homepage' => true]);

        Blog::query()->take(5)->get()->each(function (Blog $blog) use ($collection): void {
            $collection->addItem($blog, $blog->description);
        });

        $collectionResource = $this->service->collections()[0]->toArray(request());

        $this->assertCount(3, $collectionResource['items']);
    }

    /** @test */
    public function itCachesTheCollections(): void
    {
        Collection::query()->update(['display_on_homepage' => true]);

        $this->assertFalse(Cache::has(config('coeliac.cache.collections.home')));

        $collections = $this->service->collections();

        $this->assertTrue(Cache::has(config('coeliac.cache.collections.home')));
        $this->assertSame($collections, Cache::get(config('coeliac.cache.collections.home')));
    }

    /** @test */
    public function itLoadsTheCollectionsFromTheCache(): void
    {
        Collection::query()->update(['display_on_homepage' => true]);

        DB::enableQueryLog();

        $this->service->collections();

        // collections and media/item relation;
        $this->assertCount(2, DB::getQueryLog());

        $this->service->collections();

        $this->assertCount(2, DB::getQueryLog());
    }
}
