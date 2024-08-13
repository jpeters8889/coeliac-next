<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\OpenGraphImages;

use App\Actions\OpenGraphImages\GenerateTownOpenGraphImageAction;
use App\Models\EatingOut\EateryTown;
use Illuminate\View\View;
use Tests\TestCase;

class GenerateTownOpenGraphImageActionTest extends TestCase
{
    /** @test */
    public function itReturnsTheView(): void
    {
        $town = $this->create(EateryTown::class);

        $action = app(GenerateTownOpenGraphImageAction::class)->handle($town);

        $this->assertInstanceOf(View::class, $action);
        $this->assertEquals('og-images.eating-out.town', $action->name());
        $this->assertArrayHasKeys(['town', 'eateries', 'attractions', 'hotels', 'reviews', 'width'], $action->getData());
        $this->assertTrue($town->is($action->getData()['town']));
    }
}
