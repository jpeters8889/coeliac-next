<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Blogs;

use App\Jobs\OpenGraphImages\CreateBlogIndexPageOpenGraphImageJob;
use App\Jobs\OpenGraphImages\CreateHomePageOpenGraphImageJob;
use App\Models\Blogs\Blog;
use App\Scopes\LiveScope;
use Illuminate\Support\Facades\Bus;
use Tests\Concerns\CanBePublishedTestTrait;
use Tests\Concerns\CommentableTestTrait;
use Tests\Concerns\DisplaysMediaTestTrait;
use Tests\Concerns\LinkableModelTestTrait;
use Tests\TestCase;

class BlogModelTest extends TestCase
{
    use CanBePublishedTestTrait;
    use CommentableTestTrait;
    use DisplaysMediaTestTrait;
    use LinkableModelTestTrait;

    protected Blog $blog;

    public function setUp(): void
    {
        parent::setUp();

        $this->withBlogs(1);

        $this->blog = Blog::query()->first();

        $this->setUpDisplaysMediaTest(fn () => $this->create(Blog::class));

        $this->setUpLinkableModelTest(fn (array $params) => $this->create(Blog::class, $params));

        $this->setUpCommentsTest(fn (array $params = []) => $this->create(Blog::class, $params));

        $this->setUpCanBePublishedModelTest(fn (array $params = []) => $this->create(Blog::class, $params));
    }

    /** @test */
    public function itDispatchesTheCreateOpenGraphImageJobWhenSaved(): void
    {
        config()->set('coeliac.generate_og_images', true);

        Bus::fake();

        $this->create(Blog::class);

        Bus::assertDispatched(CreateBlogIndexPageOpenGraphImageJob::class);
        Bus::assertDispatched(CreateHomePageOpenGraphImageJob::class);
    }

    /** @test */
    public function itHasTags(): void
    {
        $this->assertEquals(3, $this->blog->tags()->count());
    }

    /** @test */
    public function itHasTheLiveScopeApplied(): void
    {
        $this->assertTrue(Blog::hasGlobalScope(LiveScope::class));
    }
}
