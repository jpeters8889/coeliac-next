<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\About;

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
}
