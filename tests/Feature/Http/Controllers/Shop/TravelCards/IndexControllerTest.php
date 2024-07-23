<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Shop\TravelCards;

use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class IndexControllerTest extends TestCase
{
    /** @test */
    public function itLoadsThePageAndRendersTheInertiaView(): void
    {
        $this->get(route('shop.travel-cards.landing-page'))
            ->assertInertia(fn (Assert $page) => $page->component('Shop/TravelCards'))
            ->assertOk();
    }
}
