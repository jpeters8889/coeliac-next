<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\EatingOut;

use App\Actions\EatingOut\CreateEateryReportAction;
use App\Jobs\EatingOut\ProcessReviewImagesJob;
use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryReview;
use Database\Seeders\EateryScaffoldingSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Queue;
use Tests\RequestFactories\EateryCreateReviewRequestFactory;
use Tests\TestCase;

class CreateEateryReportActionTest extends TestCase
{
    use WithFaker;

    protected Eatery $eatery;

    protected function setUp(): void
    {
        parent::setUp();

        Queue::fake();

        $this->seed(EateryScaffoldingSeeder::class);

        $this->eatery = $this->create(Eatery::class);
    }

    /** @test */
    public function itCreatesAStandardRating(): void
    {
        $this->assertEmpty($this->eatery->reports);

        $this->callAction(CreateEateryReportAction::class, $this->eatery, 'Foo');

        $this->assertNotEmpty($this->eatery->refresh()->reports);

        $report = $this->eatery->reports->first();
        $this->assertEquals('Foo', $report->details);
    }
}
