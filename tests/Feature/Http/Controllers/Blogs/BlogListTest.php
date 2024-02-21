<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Blogs;

use App\Actions\Blogs\GetBlogsForBlogIndexAction;
use App\Models\Blogs\Blog;
use App\Models\Blogs\BlogTag;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class BlogListTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('media');

        $this->withBlogs(30);
    }

    /** @test */
    public function itLoadsTheBlogListPage(): void
    {
        $this->get(route('blog.index'))->assertOk();
    }

    /** @test */
    public function itCallsTheGetBlogsForIndexAction(): void
    {
        $this->expectAction(GetBlogsForBlogIndexAction::class)
            ->get(route('blog.index'));

        $tag = BlogTag::query()->first();

        $this->expectAction(GetBlogsForBlogIndexAction::class, [BlogTag::class])
            ->get(route('blog.index.tags', ['tag' => $tag->slug]));
    }

    /** @test */
    public function itReturnsTheFirst12Blogs(): void
    {
        $this->get(route('blog.index'))
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
                    ->where('blogs.data.0.title', 'Blog 0')
                    ->where('blogs.data.1.title', 'Blog 1')
                    ->has('blogs.links')
                    ->has('blogs.meta')
                    ->where('blogs.meta.current_page', 1)
                    ->where('blogs.meta.per_page', 12)
                    ->where('blogs.meta.total', 30)
                    ->etc()
            );
    }

    /** @test */
    public function itCanLoadOtherPages(): void
    {
        $this->get(route('blog.index', ['page' => 2]))
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

    /** @test */
    public function itHasTheTagsInTheResponse(): void
    {
        $tag = $this->create(BlogTag::class);

        Blog::query()->latest()->take(2)->get()->each(function (Blog $blog) use ($tag): void {
            $blog->tags()->attach($tag);
        });

        $tags = BlogTag::query()
            ->withCount('blogs')
            ->get()
            ->sortByDesc('blogs_count');

        $this->get(route('blog.index'))
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('Blog/Index')
                    ->has('tags', 14, fn (Assert $page) => $page->hasAll(['slug', 'tag', 'blogs_count'])->etc())
                    ->where('tags.0.tag', $tags->first()->tag)
                    ->where('tags.0.slug', $tags->first()->slug)
                    ->where('tags.0.blogs_count', 2)
                    ->etc()
            );
    }
}
