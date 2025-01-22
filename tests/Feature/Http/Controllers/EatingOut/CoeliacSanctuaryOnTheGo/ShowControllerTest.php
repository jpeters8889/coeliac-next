<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\EatingOut\CoeliacSanctuaryOnTheGo;

use App\Actions\OpenGraphImages\GetOpenGraphImageForRouteAction;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ShowControllerTest extends TestCase
{
    /** @test */
    public function itRendersTheInertiaPage(): void
    {
        $this
            ->get(route('eating-out.app'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page->component('EatingOut/CoeliacSanctuaryOnTheGo'));
    }

    /** @test */
    public function itCallsTheGetOpenGraphImageForRouteAction(): void
    {
        $this->expectAction(GetOpenGraphImageForRouteAction::class, ['eatery-app'], false, then: fn ($mock) => $mock->twice());

        $this->get(route('eating-out.app'));
    }
}
