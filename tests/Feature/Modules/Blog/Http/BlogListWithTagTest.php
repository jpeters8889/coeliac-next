<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Blog\Http;

use App\Actions\Blogs\GetBlogTagsAction;
use App\Models\Blogs\Blog;
use App\Models\Blogs\BlogTag;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class BlogListWithTagTest extends TestCase
{
    protected BlogTag $tag;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('media');

        $this->withBlogs(30);

        $this->tag = $this->create(BlogTag::class);

        Blog::query()->latest()->take(2)->get()->each(function (Blog $blog): void {
            $blog->tags()->attach($this->tag);
        });
    }

    /** @test */
    public function itLoadsTheBlogListPage(): void
    {
        $this->get(route('blog.index.tags', ['tag' => $this->tag->slug]))->assertOk();
    }

    /** @test */
    public function itCallsTheGetBlogTagsAction(): void
    {
        $this->expectAction(GetBlogTagsAction::class)
            ->get(route('blog.index'));

        $tag = BlogTag::query()->first();

        $this->expectAction(GetBlogTagsAction::class)
            ->get(route('blog.index.tags', ['tag' => $tag->slug]));
    }

    /** @test */
    public function itOnlyReturnsBlogsWithTheGivenTag(): void
    {
        $this->get(route('blog.index.tags', ['tag' => $this->tag->slug]), )
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('Blog/Index')
                    ->has('blogs')
                    ->has('blogs.data', 2, fn (Assert $page) => $page->hasAll(['title', 'description', 'date', 'image', 'link', 'description', 'tags', 'comments_count']))
                    ->where('blogs.data.0.title', 'Blog 0')
                    ->has('blogs.links')
                    ->has('blogs.meta')
                    ->where('blogs.meta.current_page', 1)
                    ->where('blogs.meta.per_page', 12)
                    ->where('blogs.meta.total', 2)
                    ->etc()
            );
    }

    /** @test */
    public function itCanLoadOtherPages(): void
    {
        $this->tag = $this->create(BlogTag::class);

        Blog::query()->get()->each(function (Blog $blog): void {
            $blog->tags()->attach($this->tag);
        });

        $this->get(route('blog.index.tags', ['tag' => $this->tag->slug, 'page' => 2]))
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('Blog/Index')
                    ->has('blogs')
                    ->has(
                        'blogs.data',
                        12,
                        fn (Assert $page) => $page
                            ->hasAll(['title', 'description', 'date', 'image', 'link', 'description', 'tags', 'comments_count'])
                    )
                    ->where('blogs.data.0.title', 'Blog 12')
                    ->where('blogs.data.1.title', 'Blog 13')
                    ->has('blogs.links')
                    ->has('blogs.meta')
                    ->where('blogs.meta.current_page', 2)
                    ->where('blogs.meta.per_page', 12)
                    ->where('blogs.meta.total', 30)
                    ->etc()
            );
    }
}
