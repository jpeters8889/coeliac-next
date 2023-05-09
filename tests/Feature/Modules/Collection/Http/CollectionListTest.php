<?php

namespace Tests\Feature\Modules\Collection\Http;

use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class CollectionListTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('media');

        $this->withCollections(30);
    }

    /** @test */
    public function itLoadsTheCollectionListPage(): void
    {
        $this->get(route('collection.index'))->assertOk();
    }

    /** @test */
    public function itReturnsTheFirst12Recipes(): void
    {
        $this->get(route('collection.index'))
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('Collection/Index')
                    ->has('collections')
                    ->has(
                        'collections.data',
                        12,
                        fn (Assert $page) => $page->hasAll(['title', 'description', 'date', 'image', 'link'])
                    )
                    ->where('collections.data.0.title', 'Collection 0')
                    ->where('collections.data.1.title', 'Collection 1')
                    ->has('collections.links')
                    ->has('collections.meta')
                    ->where('collections.meta.current_page', 1)
                    ->where('collections.meta.per_page', 12)
                    ->where('collections.meta.total', 30)
                    ->etc()
            );
    }

    /** @test */
    public function itCanLoadOtherPages(): void
    {
        $this->get(route('collection.index', ['page' => 2]))
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('Collection/Index')
                    ->has('collections')
                    ->has(
                        'collections.data',
                        12,
                        fn (Assert $page) => $page
                            ->hasAll(['title', 'description', 'date', 'image', 'link'])
                    )
                    ->where('collections.data.0.title', 'Collection 12')
                    ->where('collections.data.1.title', 'Collection 13')
                    ->has('collections.links')
                    ->has('collections.meta')
                    ->where('collections.meta.current_page', 2)
                    ->where('collections.meta.per_page', 12)
                    ->where('collections.meta.total', 30)
                    ->etc()
            );
    }
}
