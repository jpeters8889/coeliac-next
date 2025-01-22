<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Blogs;

use PHPUnit\Framework\Attributes\Test;
use App\Actions\Blogs\GetLatestBlogsForHomepageAction;
use App\Models\Blogs\Blog;
use App\Resources\Blogs\BlogSimpleCardViewResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GetLatestBlogsForHomePageActionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('media');

        $this->withBlogs();
    }

    #[Test]
    public function itCanReturnACollectionOfBlogs(): void
    {
        $this->assertInstanceOf(AnonymousResourceCollection::class, $this->callAction(GetLatestBlogsForHomepageAction::class));
    }

    #[Test]
    public function itOnlyReturnsTheBlogAsACardResource(): void
    {
        $this->callAction(GetLatestBlogsForHomepageAction::class)->each(function ($item): void {
            $this->assertInstanceOf(BlogSimpleCardViewResource::class, $item);
        });
    }

    #[Test]
    public function itReturnsSixBlogs(): void
    {
        $this->assertCount(6, $this->callAction(GetLatestBlogsForHomepageAction::class));
    }

    #[Test]
    public function itReturnsTheLatestBlogsFirst(): void
    {
        $blogTitles = $this->callAction(GetLatestBlogsForHomepageAction::class)->map(fn (BlogSimpleCardViewResource $blog) => $blog->title);

        $this->assertContains('Blog 0', $blogTitles);
        $this->assertContains('Blog 1', $blogTitles);
        $this->assertNotContains('Blog 9', $blogTitles);
    }

    #[Test]
    public function itDoesntReturnBlogsThatArentLive(): void
    {
        Blog::query()->first()->update(['live' => false]);

        $blogTitles = $this->callAction(GetLatestBlogsForHomepageAction::class)->map(fn (BlogSimpleCardViewResource $blog) => $blog->title);

        $this->assertNotContains('Blog 0', $blogTitles);
        $this->assertContains('Blog 2', $blogTitles);
    }

    #[Test]
    public function itCachesTheBlogs(): void
    {
        $this->assertFalse(Cache::has(config('coeliac.cache.blogs.home')));

        $blogs = $this->callAction(GetLatestBlogsForHomepageAction::class);

        $this->assertTrue(Cache::has(config('coeliac.cache.blogs.home')));
        $this->assertSame($blogs, Cache::get(config('coeliac.cache.blogs.home')));
    }

    #[Test]
    public function itLoadsTheBlogsFromTheCache(): void
    {
        DB::enableQueryLog();

        $this->callAction(GetLatestBlogsForHomepageAction::class);

        // Blogs and media relation;
        $this->assertCount(2, DB::getQueryLog());

        $this->callAction(GetLatestBlogsForHomepageAction::class);

        $this->assertCount(2, DB::getQueryLog());
    }
}
