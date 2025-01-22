<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\EatingOut\ReportEatery;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use App\Actions\EatingOut\CreateEateryReportAction;
use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryCounty;
use App\Models\EatingOut\EateryTown;
use App\Models\EatingOut\NationwideBranch;
use Database\Seeders\EateryScaffoldingSeeder;
use Illuminate\Testing\TestResponse;
use Tests\RequestFactories\EateryCreateReviewRequestFactory;
use Tests\TestCase;

class StoreControllerTest extends TestCase
{
    protected EateryCounty $county;

    protected EateryTown $town;

    protected Eatery $eatery;

    protected NationwideBranch $nationwideBranch;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(EateryScaffoldingSeeder::class);

        $this->county = EateryCounty::query()->withoutGlobalScopes()->first();
        $this->town = EateryTown::query()->withoutGlobalScopes()->first();

        $this->eatery = $this->create(Eatery::class);

        $this->nationwideBranch = $this->create(NationwideBranch::class, [
            'wheretoeat_id' => $this->eatery->id,
        ]);
    }

    #[Test]
    #[DataProvider('routesToVisit')]
    public function itReturnsNotFoundForAnEateryThatDoesntExist(callable $route): void
    {
        $this->post($route($this, 'foo'))->assertNotFound();
    }

    #[Test]
    #[DataProvider('routesToVisit')]
    public function itReturnsNotFoundForAnEateryThatIsNotLive(callable $route): void
    {
        $eatery = $this->build(Eatery::class)->notLive()->create();

        $this->post($route($this, $eatery->slug))->assertNotFound();
    }

    #[Test]
    #[DataProvider('routesToVisit')]
    public function itErrorsWithAnInvalidReportDetails(callable $route): void
    {
        $this->submitForm($route, EateryCreateReviewRequestFactory::new(['details' => null])->create())
            ->assertSessionHasErrors('details');

        $this->submitForm($route, EateryCreateReviewRequestFactory::new(['details' => true])->create())
            ->assertSessionHasErrors('details');

        $this->submitForm($route, EateryCreateReviewRequestFactory::new(['details' => 123])->create())
            ->assertSessionHasErrors('details');
    }

    #[Test]
    #[DataProvider('routesToVisit')]
    public function itCallsTheCreateEateryReportAction(callable $route): void
    {
        $this->expectAction(CreateEateryReportAction::class);

        $this->submitForm($route, ['details' => 'foo']);

    }

    #[Test]
    #[DataProvider('routesToVisit')]
    public function itCreatesAFullRatingThatIsNotApproved(callable $route): void
    {
        $this->assertEmpty($this->eatery->reports);

        $this->submitForm($route, ['details' => 'foo']);

        $this->assertNotEmpty($this->eatery->refresh()->reports);

        $report = $this->eatery->reports->first();

        $this->assertEquals('foo', $report->details);
    }

    protected function submitForm(callable $route, array $data): TestResponse
    {
        return $this->post($route($this), $data);
    }

    public static function routesToVisit(): array
    {
        return [
            'normal eatery' => [
                function (self $test, ?string $eatery = null): string {
                    if ( ! $eatery) {
                        $eatery = $test->eatery->slug;
                    }

                    return route('eating-out.show.report.create', ['county' => $test->county, 'town' => $test->town, 'eatery' => $eatery]);
                }
            ],
            'nationwide eatery' => [
                function (self $test, ?string $eatery = null): string {
                    if ( ! $eatery) {
                        $eatery = $test->eatery->slug;
                    }

                    return route('eating-out.nationwide.show.report.create', ['eatery' => $eatery]);
                }
            ],
            'nationwide branch' => [
                function (self $test, ?string $eatery = null): string {
                    if ( ! $eatery) {
                        $eatery = $test->eatery->slug;
                    }

                    return route('eating-out.nationwide.show.branch.report.create', [
                        'eatery' => $eatery,
                        'nationwideBranch' => $test->nationwideBranch->slug,
                    ]);
                }
            ]
        ];
    }
}
