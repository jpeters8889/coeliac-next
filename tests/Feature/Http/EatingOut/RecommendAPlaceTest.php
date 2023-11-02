<?php

declare(strict_types=1);

namespace Feature\Http\EatingOut;

use Illuminate\Testing\TestResponse;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class RecommendAPlaceTest extends TestCase
{
    protected function visitPage(): TestResponse
    {
        return $this->get(route('eating-out.recommend.index'));
    }

    /** @test */
    public function itReturnsOk(): void
    {
        $this->visitPage()->assertOk();
    }

    /** @test */
    public function itRendersTheInertiaPage(): void
    {
        $this->visitPage()->assertInertia(fn (Assert $page) => $page->component('EatingOut/RecommendAPlace'));
    }
}
