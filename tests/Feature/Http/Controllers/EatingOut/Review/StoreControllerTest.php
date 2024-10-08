<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\EatingOut\Review;

use App\Actions\EatingOut\CreateEateryReviewAction;
use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryCounty;
use App\Models\EatingOut\EateryReview;
use App\Models\EatingOut\EateryTown;
use App\Models\EatingOut\NationwideBranch;
use Database\Seeders\EateryScaffoldingSeeder;
use Illuminate\Support\Arr;
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

    /**
     * @test
     * @dataProvider routesToVisit
     */
    public function itReturnsNotFoundForAnEateryThatDoesntExist(callable $route, callable $data, $before): void
    {
        $before($this);

        $this->post($route($this, 'foo'))->assertNotFound();
    }

    /**
     * @test
     * @dataProvider routesToVisit
     */
    public function itReturnsNotFoundForAnEateryThatIsNotLive(callable $route, callable $data, $before): void
    {
        $before($this);

        $eatery = $this->build(Eatery::class)->notLive()->create();

        $this->post($route($this, $eatery->slug))->assertNotFound();
    }

    /**
     * @test
     * @dataProvider routesToVisit
     */
    public function itErrorsWithoutAnInvalidRating(callable $route, callable $data, $before): void
    {
        $before($this);

        $this->submitForm($route, $data(['rating' => null])->create())
            ->assertSessionHasErrors('rating');

        $this->submitForm($route, $data(['rating' => 'foo'])->create())
            ->assertSessionHasErrors('rating');

        $this->submitForm($route, $data(['rating' => true])->create())
            ->assertSessionHasErrors('rating');

        $this->submitForm($route, $data(['rating' => -1])->create())
            ->assertSessionHasErrors('rating');

        $this->submitForm($route, $data(['rating' => 6])->create())
            ->assertSessionHasErrors('rating');
    }

    /**
     * @test
     * @dataProvider routesToVisit
     */
    public function itFailsWithAnInvalidMethodValue(callable $route, callable $data, $before): void
    {
        $before($this);

        $this->submitForm($route, $data(['method' => null])->create())
            ->assertSessionHasErrors('method');

        $this->submitForm($route, $data(['method' => 123])->create())
            ->assertSessionHasErrors('method');

        $this->submitForm($route, $data(['method' => false])->create())
            ->assertSessionHasErrors('method');

        $this->submitForm($route, $data(['method' => 'foo'])->create())
            ->assertSessionHasErrors('method');
    }

    /**
     * @test
     * @dataProvider routesToVisit
     */
    public function itErrorsWithoutABranchNameWhenTheEateryIsNationwide(callable $route, callable $data, $before): void
    {
        $before($this);

        $this->eatery->county->update(['county' => 'Nationwide']);

        $this->submitForm($route, $data(['branch_name' => 123])->create())
            ->assertSessionHasErrors('branch_name');

        $this->submitForm($route, $data(['branch_name' => false])->create())
            ->assertSessionHasErrors('branch_name');
    }

    /**
     * @test
     * @dataProvider routesToVisit
     */
    public function itErrorsWithoutAName(callable $route, callable $data, $before): void
    {
        $before($this);

        $this->submitForm($route, $data()->state(['name' => null])->create())
            ->assertSessionHasErrors('name');

        $this->submitForm($route, $data()->state(['name' => 123])->create())
            ->assertSessionHasErrors('name');

        $this->submitForm($route, $data()->state(['name' => true])->create())
            ->assertSessionHasErrors('name');
    }

    /**
     * @test
     * @dataProvider routesToVisit
     */
    public function itErrorsWithoutAEmail(callable $route, callable $data, $before): void
    {
        $before($this);

        $this->submitForm($route, $data()->state(['email' => null])->create())
            ->assertSessionHasErrors('email');

        $this->submitForm($route, $data()->state(['email' => 123])->create())
            ->assertSessionHasErrors('email');

        $this->submitForm($route, $data()->state(['email' => true])->create())
            ->assertSessionHasErrors('email');

        $this->submitForm($route, $data()->state(['email' => 'foo'])->create())
            ->assertSessionHasErrors('email');
    }

    /**
     * @test
     * @dataProvider routesToVisit
     */
    public function itErrorsWithoutAReviewField(callable $route, callable $data, $before): void
    {
        $before($this);

        $this->submitForm($route, $data()->state(['review' => null])->create())
            ->assertSessionHasErrors('review');

        $this->submitForm($route, $data()->state(['review' => 123])->create())
            ->assertSessionHasErrors('review');

        $this->submitForm($route, $data()->state(['review' => true])->create())
            ->assertSessionHasErrors('review');
    }

    /**
     * @test
     * @dataProvider routesToVisit
     */
    public function itErrorsWithAnInvalidFoodRatingValue(callable $route, callable $data, $before): void
    {
        $before($this);

        $this->submitForm($route, $data()->state(['food_rating' => 123])->create())
            ->assertSessionHasErrors('food_rating');

        $this->submitForm($route, $data()->state(['food_rating' => true])->create())
            ->assertSessionHasErrors('food_rating');

        $this->submitForm($route, $data()->state(['food_rating' => 'foo'])->create())
            ->assertSessionHasErrors('food_rating');
    }

    /**
     * @test
     * @dataProvider routesToVisit
     */
    public function itErrorsWithAnInvalidServiceRatingValue(callable $route, callable $data, $before): void
    {
        $before($this);

        $this->submitForm($route, $data()->state(['service_rating' => 123])->create())
            ->assertSessionHasErrors('service_rating');

        $this->submitForm($route, $data()->state(['service_rating' => true])->create())
            ->assertSessionHasErrors('service_rating');

        $this->submitForm($route, $data()->state(['service_rating' => 'foo'])->create())
            ->assertSessionHasErrors('service_rating');
    }

    /**
     * @test
     * @dataProvider routesToVisit
     */
    public function itErrorsWithoutAnInvalidHowExpensiveField(callable $route, callable $data, $before): void
    {
        $before($this);

        $this->submitForm($route, $data(['how_expensive' => 'foo'])->create())
            ->assertSessionHasErrors('how_expensive');

        $this->submitForm($route, $data(['how_expensive' => true])->create())
            ->assertSessionHasErrors('how_expensive');

        $this->submitForm($route, $data(['how_expensive' => -1])->create())
            ->assertSessionHasErrors('how_expensive');

        $this->submitForm($route, $data(['how_expensive' => 6])->create())
            ->assertSessionHasErrors('how_expensive');
    }

    /**
     * @test
     * @dataProvider routesToVisit
     */
    public function itErrorsIfSubmittingMoreThan6Images(callable $route, callable $data, $before): void
    {
        $before($this);

        $this->submitForm($route, $data(['images' => [1, 2, 3, 4, 5, 6, 7]])->create())
            ->assertSessionHasErrors('images');
    }

    /**
     * @test
     * @dataProvider routesToVisit
     */
    public function itErrorsIfAnImageDoesntExistInTheTable(callable $route, callable $data, $before): void
    {
        $before($this);

        $this->submitForm($route, $data(['images' => [1]])->create())
            ->assertSessionHasErrors('images.0');
    }

    /**
     * @test
     * @dataProvider routesToVisit
     */
    public function itReturnsOk(callable $route, callable $data, $before): void
    {
        $before($this);

        $this->submitForm($route, $data()->create())->assertSessionHasNoErrors();
    }

    /**
     * @test
     * @dataProvider routesToVisit
     */
    public function itCallsTheCreateEateryReviewAction(callable $route, callable $data, $before): void
    {
        $before($this);

        $this->expectAction(CreateEateryReviewAction::class);

        $this->submitForm($route, $data(['rating' => 5])->create());

    }

    /**
     * @test
     * @dataProvider routesToVisit
     */
    public function itCreatesAFullRatingThatIsNotApproved(callable $route, callable $data, $before): void
    {
        $before($this);

        $this->assertEmpty($this->eatery->reviews);

        $this->submitForm($route, $data()
            ->state([
                'rating' => 4,
                'name' => 'Foo Bar',
                'email' => 'foo@bar.com',
            ])
            ->create());

        $this->assertNotEmpty($this->eatery->reviews()->withoutGlobalScopes()->get());

        $review = EateryReview::query()->withoutGlobalScopes()->first();

        $this->assertFalse($review->approved);
        $this->assertEquals(4, $review->rating);
        $this->assertEquals('Foo Bar', $review->name);
        $this->assertEquals('foo@bar.com', $review->email);
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
                    return route('eating-out.show.reviews.create', [
                        'county' => $test->county->slug,
                        'town' => $test->town->slug,
                        'eatery' => $eatery ?? $test->eatery->slug,
                    ]);
                },
                fn (array $data = []): EateryCreateReviewRequestFactory
                => EateryCreateReviewRequestFactory::new($data),
                function (): void {},
            ],
            'nationwide eatery' => [
                function (self $test, ?string $eatery = null): string {
                    return route('eating-out.nationwide.show.reviews.create', [
                        'eatery' => $eatery ?? $test->eatery->slug,
                    ]);
                },
                function (array $data = []): EateryCreateReviewRequestFactory {
                    $request = EateryCreateReviewRequestFactory::new($data);

                    if ( ! Arr::hasAny($data, ['nationwide_branch', 'branch_name'])) {
                        $request = $request->forBranch();
                    }

                    return $request;
                },
                function (self $test): void {
                    $test->county->update(['county' => 'Nationwide']);
                    $test->town->update(['town' => 'nationwide']);
                }
            ],
            'nationwide branch' => [
                function (self $test, ?string $eatery = null): string {
                    return route('eating-out.nationwide.show.branch.reviews.create', [
                        'eatery' => $eatery ?? $test->eatery->slug,
                        'nationwideBranch' => $test->nationwideBranch->slug,
                    ]);
                }  ,
                function (array $data = []): EateryCreateReviewRequestFactory {
                    $request = EateryCreateReviewRequestFactory::new($data);

                    if ( ! Arr::hasAny($data, ['nationwide_branch', 'branch_name'])) {
                        $request = $request->forBranch();
                    }

                    return $request;
                },
                function (self $test): void {
                    $test->county->update(['county' => 'Nationwide']);
                    $test->town->update(['town' => 'nationwide']);
                },
            ],
        ];
    }
}
