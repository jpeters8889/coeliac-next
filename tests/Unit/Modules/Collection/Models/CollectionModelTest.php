<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Collection\Models;

use App\Modules\Blog\Models\Blog;
use App\Modules\Collection\Models\Collection;
use App\Modules\Shared\Scopes\LiveScope;
use Tests\TestCase;
use Tests\Unit\Modules\Shared\Support\CanBePublishedTestTrait;
use Tests\Unit\Modules\Shared\Support\DisplaysMediaTestTrait;
use Tests\Unit\Modules\Shared\Support\LinkableModelTestTrait;

class CollectionModelTest extends TestCase
{
    use CanBePublishedTestTrait;
    use DisplaysMediaTestTrait;
    use LinkableModelTestTrait;

    protected Collection $collection;

    public function setUp(): void
    {
        parent::setUp();

        $this->withCollections(1);

        $this->collection = Collection::query()->first();

        $this->setUpDisplaysMediaTest(fn () => $this->create(Collection::class));

        $this->setUpLinkableModelTest(fn (array $params) => $this->create(Collection::class, $params));

        $this->setUpCanBePublishedModelTest(fn (array $params = []) => $this->create(Collection::class, $params));
    }

    /** @test */
    public function itHasTheLiveScopeApplied(): void
    {
        $this->assertTrue(Collection::hasGlobalScope(LiveScope::class));
    }

    /** @test */
    public function itCanHaveItemsAddedToTheCollection(): void
    {
        $this->assertEmpty($this->collection->items);

        /** @var Blog $blog */
        $blog = $this->create(Blog::class);

        $this->collection->addItem($blog, $blog->meta_description)->refresh();

        $this->assertNotEmpty($this->collection->items);
    }
}
