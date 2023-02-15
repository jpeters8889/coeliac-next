<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Blog;

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
                            ->hasAll(['title', 'description', 'date', 'image', 'link', 'description', 'tags'])
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
}
