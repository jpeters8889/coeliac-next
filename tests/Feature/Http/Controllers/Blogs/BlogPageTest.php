<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Blogs;

use App\Actions\Comments\GetCommentsForItemAction;
use App\Models\Blogs\Blog;
use Illuminate\Testing\TestResponse;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class BlogPageTest extends TestCase
{
    protected Blog $blog;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withBlogs(1);

        $this->blog = Blog::query()->first();
    }

    /** @test */
    public function itReturnsNotFoundForABlogThatDoesntExist(): void
    {
        $this->get(route('blog.show', ['blog' => 'foobar']))->assertNotFound();
    }

    protected function visitBlog(): TestResponse
    {
        return $this->get(route('blog.show', ['blog' => $this->blog]));
    }

    /** @test */
    public function itReturnsNotFoundForABlogThatIsntLive(): void
    {
        $this->blog->update(['live' => false]);

        $this->visitBlog()->assertNotFound();
    }

    /** @test */
    public function itReturnsOkForABlogThatIsLive(): void
    {
        $this->visitBlog()->assertOk();
    }

    /** @test */
    public function itCallsTheGetCommentsForItemAction(): void
    {
        $this->expectAction(GetCommentsForItemAction::class, [Blog::class]);

        $this->visitBlog();
    }

    /** @test */
    public function itRendersTheInertiaPage(): void
    {
        $this->visitBlog()
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('Blog/Show')
                    ->has('blog')
                    ->where('blog.title', 'Blog 0')
                    ->etc()
            );
    }
}
