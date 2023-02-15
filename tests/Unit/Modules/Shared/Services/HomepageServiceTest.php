<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Shared\Services;

use App\Modules\Blog\Models\Blog;
use App\Modules\Blog\Resources\BlogSimpleCardViewResource;
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

        $this->withBlogs(5);
    }

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
    public function itReturnsTwoBlogs(): void
    {
        $this->assertCount(2, $this->service->blogs());
    }

    /** @test */
    public function itReturnsTheLatestBlogsFirst(): void
    {
        $blogTitles = $this->service->blogs()->map(fn (BlogSimpleCardViewResource $blog) => $blog->title);

        $this->assertContains('Blog 0', $blogTitles);
        $this->assertContains('Blog 1', $blogTitles);
        $this->assertNotContains('Blog 4', $blogTitles);
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
}
