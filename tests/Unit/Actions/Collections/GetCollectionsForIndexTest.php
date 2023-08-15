<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Collections;

use App\Actions\Collections\GetCollectionsForIndexAction;
use App\Models\Collections\Collection;
use App\Resources\Collections\CollectionDetailCardViewResource;
use App\Resources\Collections\CollectionListCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GetCollectionsForIndexTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('media');

        $this->withCollections(15);
    }

    /** @test */
    public function itReturnsACollectionListCollection(): void
    {
        $this->assertInstanceOf(
            CollectionListCollection::class,
            $this->callAction(GetCollectionsForIndexAction::class),
        );
    }

    /** @test */
    public function itIsAPaginatedCollection(): void
    {
        $collections = $this->callAction(GetCollectionsForIndexAction::class);

        $this->assertInstanceOf(LengthAwarePaginator::class, $collections->resource);
    }

    /** @test */
    public function itReturns12ItemsPerPageByDefault(): void
    {
        $this->assertCount(12, $this->callAction(GetCollectionsForIndexAction::class));
    }

    /** @test */
    public function itCanHaveADifferentPageLimitSpecified(): void
    {
        $this->assertCount(5, $this->callAction(GetCollectionsForIndexAction::class, perPage: 5));
    }

    /** @test */
    public function eachItemInThePageIsACollectionDetailCardViewResource(): void
    {
        $resource = $this->callAction(GetCollectionsForIndexAction::class)->resource->first();

        $this->assertInstanceOf(CollectionDetailCardViewResource::class, $resource);
    }

    /** @test */
    public function itLoadsTheMediaAndTagsRelationship(): void
    {
        /** @var Collection $collection */
        $collection = $this->callAction(GetCollectionsForIndexAction::class)->resource->first()->resource;

        $this->assertTrue($collection->relationLoaded('media'));
    }

    /** @test */
    public function itHasAnItemsCount(): void
    {
        /** @var Collection $collection */
        $collection = $this->callAction(GetCollectionsForIndexAction::class)->resource->first()->resource;

        $this->assertArrayHasKey('items_count', $collection->attributesToArray());
    }
}
