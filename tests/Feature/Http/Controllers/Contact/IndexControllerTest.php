<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Contact;

use App\Actions\OpenGraphImages\GetOpenGraphImageForRouteAction;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class IndexControllerTest extends TestCase
{
    /** @test */
    public function itLoadsThePageAndRendersTheInertiaView(): void
    {
        $this->get(route('contact.index'))
            ->assertInertia(fn (Assert $page) => $page->component('Contact'))
            ->assertOk();
    }

    /** @test */
    public function itCallsTheGetOpenGraphImageForRouteAction(): void
    {
        $this->expectAction(GetOpenGraphImageForRouteAction::class);

        $this->get(route('contact.index'));
    }
}
