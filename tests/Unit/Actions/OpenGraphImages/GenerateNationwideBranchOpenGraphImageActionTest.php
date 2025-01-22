<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\OpenGraphImages;

use PHPUnit\Framework\Attributes\Test;
use App\Actions\OpenGraphImages\GenerateNationwideBranchOpenGraphImageAction;
use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\NationwideBranch;
use Illuminate\View\View;
use Tests\TestCase;

class GenerateNationwideBranchOpenGraphImageActionTest extends TestCase
{
    #[Test]
    public function itReturnsTheView(): void
    {
        $this->create(Eatery::class);
        $branch = $this->create(NationwideBranch::class);

        $action = app(GenerateNationwideBranchOpenGraphImageAction::class)->handle($branch);

        $this->assertInstanceOf(View::class, $action);
        $this->assertEquals('og-images.eating-out.eatery', $action->name());
        $this->assertArrayHasKey('eatery', $action->getData());
        $this->assertTrue($branch->is($action->getData()['eatery']));
    }
}
