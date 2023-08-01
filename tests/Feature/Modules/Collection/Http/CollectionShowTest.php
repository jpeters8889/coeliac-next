<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Collection\Http;

use App\Models\Collections\Collection;
use Illuminate\Testing\TestResponse;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class CollectionShowTest extends TestCase
{
    protected Collection $collection;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withCollections(1);

        $this->collection = Collection::query()->first();
    }

    /** @test */
    public function itReturnsNotFoundForARecipeThatDoesntExist(): void
    {
        $this->get(route('collection.show', ['collection' => 'foobar']))->assertNotFound();
    }

    protected function visitCollection(): TestResponse
    {
        return $this->get(route('collection.show', ['collection' => $this->collection]));
    }

    /** @test */
    public function itReturnsNotFoundForACollectionThatIsntLive(): void
    {
        $this->collection->update(['live' => false]);

        $this->visitCollection()->assertNotFound();
    }

    /** @test */
    public function itReturnsOkForACollectionThatIsLive(): void
    {
        $this->visitCollection()->assertOk();
    }

    /** @test */
    public function itRendersTheInertiaPage(): void
    {
        $this->visitCollection()
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('Collection/Show')
                    ->has('collection')
                    ->where('collection.title', 'Collection 0')
                    ->etc()
            );
    }
}
