<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Blogs;

use App\Models\Blogs\Blog;
use App\Scopes\LiveScope;
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
