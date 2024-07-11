<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\EatingOut\Reports;

use App\Actions\EatingOut\CreateEateryReportAction;
use App\Models\EatingOut\Eatery;
use Database\Seeders\EateryScaffoldingSeeder;
use Illuminate\Testing\TestResponse;
use Tests\RequestFactories\EateryCreateReviewRequestFactory;
use Tests\TestCase;

class StoreControllerTest extends TestCase
{
    protected Eatery $eatery;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(EateryScaffoldingSeeder::class);

        $this->eatery = $this->create(Eatery::class);
    }

    /** @test */
    public function itReturnsNotFoundForAnEateryThatDoesntExist(): void
    {
        $this->postJson(route('api.wheretoeat.report.store', 'foo'))->assertNotFound();
    }

    /** @test */
    public function itReturnsNotFoundForAnEateryThatIsNotLive(): void
    {
        $eatery = $this->build(Eatery::class)->notLive()->create();

        $this->postJson(route('api.wheretoeat.report.store', $eatery))->assertNotFound();
    }

    /** @test */
    public function itErrorsWithAnInvalidReportDetails(): void
    {
        $this->submitForm(EateryCreateReviewRequestFactory::new(['details' => null])->create())
            ->assertJsonValidationErrorFor('details');

        $this->submitForm(EateryCreateReviewRequestFactory::new(['details' => true])->create())
            ->assertJsonValidationErrorFor('details');

        $this->submitForm(EateryCreateReviewRequestFactory::new(['details' => 123])->create())
            ->assertJsonValidationErrorFor('details');
    }

    /** @test */
    public function itCallsTheCreateEateryReportAction(): void
    {
        $this->expectAction(CreateEateryReportAction::class);

        $this->submitForm(['details' => 'foo']);

    }

    /** @test */
    public function itCreatesAFullRatingThatIsNotApproved(): void
    {
        $this->assertEmpty($this->eatery->reports);

        $this->submitForm(['details' => 'foo']);

        $this->assertNotEmpty($this->eatery->refresh()->reports);

        $report = $this->eatery->reports->first();

        $this->assertEquals('foo', $report->details);
    }

    protected function submitForm(array $data): TestResponse
    {
        return $this->postJson(route('api.wheretoeat.report.store', $this->eatery), $data);
    }
}
