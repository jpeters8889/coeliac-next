<?php

namespace Tests\Unit\Modules\Blog\Models;

use App\Modules\Blog\Models\Blog;
use App\Modules\Blog\Models\BlogTag;
use Tests\TestCase;

class BlogModelTest extends TestCase
{
    protected Blog $blog;

    public function setUp(): void
    {
        parent::setUp();

        $this->blog = $this->build(Blog::class)
            ->has($this->build(BlogTag::class)->count(5), 'tags')
            ->create();
    }

    /** @test */
    public function itHasTags(): void
    {
        $this->assertEquals(5, $this->blog->tags()->count());
    }
}
