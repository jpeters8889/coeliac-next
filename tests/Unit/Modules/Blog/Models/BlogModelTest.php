<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Blog\Models;

use App\Models\Blogs\Blog;
use App\Scopes\LiveScope;
use Tests\TestCase;
use Tests\Unit\Modules\Shared\Comments\CommentableTestTrait;
use Tests\Unit\Modules\Shared\Support\CanBePublishedTestTrait;
use Tests\Unit\Modules\Shared\Support\DisplaysMediaTestTrait;
use Tests\Unit\Modules\Shared\Support\LinkableModelTestTrait;

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
