<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\EatingOut;

use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class EatingOutAppControllerTest extends TestCase
{
    /** @test */
    public function itRendersTheInertiaPage(): void
    {
        $this
            ->get(route('eating-out.app'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page->component('EatingOut/CoeliacSanctuaryOnTheGo'));
    }
}
