<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Blog\Models;

use App\Modules\Blog\Models\Blog;
use App\Modules\Blog\Models\BlogTag;
use Tests\TestCase;
use Tests\Unit\Modules\Shared\Support\DisplaysMediaTestTrait;
use Tests\Unit\Modules\Shared\Support\LinkableModelTestTrait;

class BlogModelTest extends TestCase
{
    use DisplaysMediaTestTrait;
    use LinkableModelTestTrait;

    protected Blog $blog;

    public function setUp(): void
    {
        parent::setUp();

        $this->blog = $this->build(Blog::class)
            ->has($this->build(BlogTag::class)->count(5), 'tags')
            ->create();

        $this->setUpDisplaysMediaTest(fn () => $this->create(Blog::class));

        $this->setUpLinkableModelTest(fn (array $params) => $this->create(Blog::class, $params));
    }

    /** @test */
    public function itHasTags(): void
    {
        $this->assertEquals(5, $this->blog->tags()->count());
    }
}
