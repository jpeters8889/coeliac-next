<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\TermsOfUse;

use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class IndexControllerTest extends TestCase
{
    /** @test */
    public function itLoadsThePageAndRendersTheInertiaView(): void
    {
        $this->get(route('terms-of-use'))
            ->assertInertia(fn (Assert $page) => $page->component('TermsOfUse'))
            ->assertOk();
    }
}
