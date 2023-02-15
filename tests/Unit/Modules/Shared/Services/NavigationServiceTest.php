<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Shared\Services;

use App\Modules\Blog\Models\Blog;
use App\Modules\Shared\DataObjects\NavigationItem;
use App\Modules\Shared\Services\NavigationService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class NavigationServiceTest extends TestCase
{
    protected NavigationService $service;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('media');

        $this->service = resolve(NavigationService::class);

        $this->withBlogs();
    }

    /** @test */
    public function itCanReturnACollectionOfBlogs(): void
    {
        $this->assertInstanceOf(Collection::class, $this->service->blogs());
    }

    /** @test */
    public function itOnlyReturnsTheBlogAsANavigationItem(): void
    {
        $this->service->blogs()->each(function ($item): void {
            $this->assertInstanceOf(NavigationItem::class, $item);
        });
    }

    /** @test */
    public function itReturnsEightBlogs(): void
    {
        $this->assertCount(8, $this->service->blogs());
    }

    /** @test */
    public function itReturnsTheLatestBlogsFirst(): void
    {
        $blogTitles = $this->service->blogs()->map(fn (NavigationItem $blog) => $blog->title);

        $this->assertContains('Blog 0', $blogTitles);
        $this->assertContains('Blog 7', $blogTitles);
        $this->assertNotContains('Blog 8', $blogTitles);
    }

    /** @test */
    public function itDoesntReturnBlogsThatArentLive(): void
    {
        Blog::query()->first()->update(['live' => false]);

        $blogTitles = $this->service->blogs()->map(fn (NavigationItem $blog) => $blog->title);

        $this->assertNotContains('Blog 0', $blogTitles);
        $this->assertContains('Blog 8', $blogTitles);
    }

    /** @test */
    public function itCachesTheBlogs(): void
    {
        $this->assertFalse(Cache::has(config('coeliac.cache.blogs.navigation')));

        $blogs = $this->service->blogs();

        $this->assertTrue(Cache::has(config('coeliac.cache.blogs.navigation')));
        $this->assertSame($blogs, Cache::get(config('coeliac.cache.blogs.navigation')));
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
