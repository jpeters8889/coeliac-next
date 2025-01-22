<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\Blogs;

use App\Models\Blogs\Blog;
use Tests\TestCase;

class GetControllerTest extends TestCase
{
    /** @test */
    public function itErrorsIfABlogCantBeFound(): void
    {
        $this->get(route('api.blogs.show', 'foo'))->assertNotFound();
    }

    /** @test */
    public function itErrorsIfABlogIsntLive(): void
    {
        $blog = $this->build(Blog::class)->notLive()->create();

        $this->get(route('api.blogs.show', $blog))->assertNotFound();
    }

    /** @test */
    public function itErrorsIfABlogIsDraft(): void
    {
        $blog = $this->build(Blog::class)->draft()->create();

        $this->get(route('api.blogs.show', $blog))->assertNotFound();
    }

    /** @test */
    public function itReturnsTheBlog(): void
    {
        $this->withBlogs(1);

        $blog = Blog::query()->first();

        $this->get(route('api.blogs.show', $blog))->assertOk();
    }
}
