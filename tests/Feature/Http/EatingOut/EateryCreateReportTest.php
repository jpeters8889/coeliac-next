<?php

declare(strict_types=1);

namespace Feature\Http\EatingOut;

use App\Actions\EatingOut\CreateEateryReportAction;
use App\Actions\EatingOut\CreateEateryReviewAction;
use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryCounty;
use App\Models\EatingOut\EateryReview;
use App\Models\EatingOut\EateryTown;
use Database\Seeders\EateryScaffoldingSeeder;
use Illuminate\Testing\TestResponse;
use Tests\RequestFactories\EateryCreateReviewRequestFactory;
use Tests\TestCase;

class EateryCreateReportTest extends TestCase
{
    protected EateryCounty $county;

    protected EateryTown $town;

    protected Eatery $eatery;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(EateryScaffoldingSeeder::class);

        $this->county = EateryCounty::query()->withoutGlobalScopes()->first();
        $this->town = EateryTown::query()->withoutGlobalScopes()->first();

        $this->eatery = $this->create(Eatery::class);
    }

    /** @test */
    public function itReturnsNotFoundForAnEateryThatDoesntExist(): void
    {
        $this->post(
            route('eating-out.show.report.create', ['county' => $this->county, 'town' => $this->town, 'eatery' => 'foo'])
        )->assertNotFound();
    }

    /** @test */
    public function itReturnsNotFoundForAnEateryThatIsNotLive(): void
    {
        $eatery = $this->build(Eatery::class)->notLive()->create();

        $this->post(
            route('eating-out.show.report.create', ['county' => $this->county, 'town' => $this->town, 'eatery' => $eatery->slug])
        )->assertNotFound();
    }

    /** @test */
    public function itErrorsWithAnInvalidReportDetails(): void
    {
        $this->submitForm(EateryCreateReviewRequestFactory::new(['details' => null])->create())
            ->assertSessionHasErrors('details');

        $this->submitForm(EateryCreateReviewRequestFactory::new(['details' => true])->create())
            ->assertSessionHasErrors('details');

        $this->submitForm(EateryCreateReviewRequestFactory::new(['details' => 123])->create())
            ->assertSessionHasErrors('details');
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
        return $this->post(
            route('eating-out.show.report.create', ['county' => $this->county, 'town' => $this->town, 'eatery' => $this->eatery->slug]),
            $data
        );
    }
}
