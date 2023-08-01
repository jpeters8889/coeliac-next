<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Blog\Actions;

use App\Actions\Blogs\GetBlogTagsAction;
use App\Models\Blogs\BlogTag;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class GetBlogTagsActionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->build(BlogTag::class)
            ->count(15)
            ->create();
    }

    /** @test */
    public function itReturnsACollectionOfBlogTags(): void
    {
        $this->assertInstanceOf(Collection::class, $this->callAction(GetBlogTagsAction::class));
    }

    /** @test */
    public function itReturns14TagsByDefault(): void
    {
        $this->assertCount(14, $this->callAction(GetBlogTagsAction::class));
    }

    /** @test */
    public function itCanReturnAGivenAmountOfTags(): void
    {
        $this->assertCount(5, $this->callAction(GetBlogTagsAction::class, 5));
    }
}
