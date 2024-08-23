<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\About;

use App\Actions\OpenGraphImages\GetOpenGraphImageForRouteAction;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class IndexControllerTest extends TestCase
{
    /** @test */
    public function itLoadsThePageAndRendersTheInertiaView(): void
    {
        $this->get(route('about'))
            ->assertInertia(fn (Assert $page) => $page->component('About'))
            ->assertOk();
    }

    /** @test */
    public function itCallsTheGetOpenGraphImageForRouteAction(): void
    {
        $this->expectAction(GetOpenGraphImageForRouteAction::class);

        $this->get(route('about'));
    }
}
