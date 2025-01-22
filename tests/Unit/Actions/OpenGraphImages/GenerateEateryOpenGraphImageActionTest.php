<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\OpenGraphImages;

use PHPUnit\Framework\Attributes\Test;
use App\Actions\OpenGraphImages\GenerateEateryOpenGraphImageAction;
use App\Models\EatingOut\Eatery;
use Illuminate\View\View;
use Tests\TestCase;

class GenerateEateryOpenGraphImageActionTest extends TestCase
{
    #[Test]
    public function itReturnsTheView(): void
    {
        $eatery = $this->create(Eatery::class);

        $action = app(GenerateEateryOpenGraphImageAction::class)->handle($eatery);

        $this->assertInstanceOf(View::class, $action);
        $this->assertEquals('og-images.eating-out.eatery', $action->name());
        $this->assertArrayHasKey('eatery', $action->getData());
        $this->assertTrue($eatery->is($action->getData()['eatery']));
    }
}
