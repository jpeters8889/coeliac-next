<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\OpenGraphImages;

use App\Actions\OpenGraphImages\GenerateCountyOpenGraphImageAction;
use App\Models\EatingOut\EateryCounty;
use Illuminate\View\View;
use Tests\TestCase;

class GenerateCountyOpenGraphImageActionTest extends TestCase
{
    /** @test */
    public function itReturnsTheView(): void
    {
        $county = $this->create(EateryCounty::class);

        $action = app(GenerateCountyOpenGraphImageAction::class)->handle($county);

        $this->assertInstanceOf(View::class, $action);
        $this->assertEquals('og-images.eating-out.county', $action->name());
        $this->assertArrayHasKeys(['county', 'towns', 'eateries', 'reviews'], $action->getData());
        $this->assertTrue($county->is($action->getData()['county']));
    }
}
