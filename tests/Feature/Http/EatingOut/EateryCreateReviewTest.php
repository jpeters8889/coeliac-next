<?php

declare(strict_types=1);

namespace Tests\Feature\Http\EatingOut;

use App\Actions\EatingOut\CreateEateryReviewAction;
use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryCounty;
use App\Models\EatingOut\EateryReview;
use App\Models\EatingOut\EateryTown;
use Database\Seeders\EateryScaffoldingSeeder;
use Illuminate\Testing\TestResponse;
use Tests\RequestFactories\EateryCreateReviewRequestFactory;
use Tests\TestCase;

class EateryCreateReviewTest extends TestCase
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
            route('eating-out.show.reviews.create', ['county' => $this->county, 'town' => $this->town, 'eatery' => 'foo'])
        )->assertNotFound();
    }

    /** @test */
    public function itReturnsNotFoundForAnEateryThatIsNotLive(): void
    {
        $eatery = $this->build(Eatery::class)->notLive()->create();

        $this->post(
            route('eating-out.show.reviews.create', ['county' => $this->county, 'town' => $this->town, 'eatery' => $eatery->slug])
        )->assertNotFound();
    }

    /** @test */
    public function itErrorsWithoutAnInvalidRating(): void
    {
        $this->submitForm(EateryCreateReviewRequestFactory::new(['rating' => null])->create())
            ->assertSessionHasErrors('rating');

        $this->submitForm(EateryCreateReviewRequestFactory::new(['rating' => 'foo'])->create())
            ->assertSessionHasErrors('rating');

        $this->submitForm(EateryCreateReviewRequestFactory::new(['rating' => true])->create())
            ->assertSessionHasErrors('rating');

        $this->submitForm(EateryCreateReviewRequestFactory::new(['rating' => -1])->create())
            ->assertSessionHasErrors('rating');

        $this->submitForm(EateryCreateReviewRequestFactory::new(['rating' => 6])->create())
            ->assertSessionHasErrors('rating');
    }

    /** @test */
    public function itFailsWithAnInvalidMethodValue(): void
    {
        $this->submitForm(EateryCreateReviewRequestFactory::new(['method' => null])->create())
            ->assertSessionHasErrors('method');

        $this->submitForm(EateryCreateReviewRequestFactory::new(['method' => 123])->create())
            ->assertSessionHasErrors('method');

        $this->submitForm(EateryCreateReviewRequestFactory::new(['method' => false])->create())
            ->assertSessionHasErrors('method');

        $this->submitForm(EateryCreateReviewRequestFactory::new(['method' => 'foo'])->create())
            ->assertSessionHasErrors('method');
    }

    /** @test */
    public function itErrorsWithoutABranchNameWhenTheEateryIsNationwide(): void
    {
        $this->eatery->county->update(['county' => 'Nationwide']);

        $this->submitForm(EateryCreateReviewRequestFactory::new(['branch_name' => null])->create())
            ->assertSessionHasErrors('branch_name');

        $this->submitForm(EateryCreateReviewRequestFactory::new(['branch_name' => 123])->create())
            ->assertSessionHasErrors('branch_name');

        $this->submitForm(EateryCreateReviewRequestFactory::new(['branch_name' => false])->create())
            ->assertSessionHasErrors('branch_name');
    }

    /** @test */
    public function itErrorsWhenSubmitAFullReviewWithoutAName(): void
    {
        $this->submitForm(EateryCreateReviewRequestFactory::new()->fullReview()->state(['name' => null])->create())
            ->assertSessionHasErrors('name');

        $this->submitForm(EateryCreateReviewRequestFactory::new()->fullReview()->state(['name' => 123])->create())
            ->assertSessionHasErrors('name');

        $this->submitForm(EateryCreateReviewRequestFactory::new()->fullReview()->state(['name' => true])->create())
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function itErrorsWhenSubmitAFullReviewWithoutAEmail(): void
    {
        $this->submitForm(EateryCreateReviewRequestFactory::new()->fullReview()->state(['email' => null])->create())
            ->assertSessionHasErrors('email');

        $this->submitForm(EateryCreateReviewRequestFactory::new()->fullReview()->state(['email' => 123])->create())
            ->assertSessionHasErrors('email');

        $this->submitForm(EateryCreateReviewRequestFactory::new()->fullReview()->state(['email' => true])->create())
            ->assertSessionHasErrors('email');

        $this->submitForm(EateryCreateReviewRequestFactory::new()->fullReview()->state(['email' => 'foo'])->create())
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function itErrorsWhenSubmitAFullReviewWithoutAReviewField(): void
    {
        $this->submitForm(EateryCreateReviewRequestFactory::new()->fullReview()->state(['review' => null])->create())
            ->assertSessionHasErrors('review');

        $this->submitForm(EateryCreateReviewRequestFactory::new()->fullReview()->state(['review' => 123])->create())
            ->assertSessionHasErrors('review');

        $this->submitForm(EateryCreateReviewRequestFactory::new()->fullReview()->state(['review' => true])->create())
            ->assertSessionHasErrors('review');
    }

    /** @test */
    public function itErrorsWithAnInvalidFoodRatingValue(): void
    {
        $this->submitForm(EateryCreateReviewRequestFactory::new()->fullReview()->state(['food_rating' => 123])->create())
            ->assertSessionHasErrors('food_rating');

        $this->submitForm(EateryCreateReviewRequestFactory::new()->fullReview()->state(['food_rating' => true])->create())
            ->assertSessionHasErrors('food_rating');

        $this->submitForm(EateryCreateReviewRequestFactory::new()->fullReview()->state(['food_rating' => 'foo'])->create())
            ->assertSessionHasErrors('food_rating');
    }

    /** @test */
    public function itErrorsWithAnInvalidServiceRatingValue(): void
    {
        $this->submitForm(EateryCreateReviewRequestFactory::new()->fullReview()->state(['service_rating' => 123])->create())
            ->assertSessionHasErrors('service_rating');

        $this->submitForm(EateryCreateReviewRequestFactory::new()->fullReview()->state(['service_rating' => true])->create())
            ->assertSessionHasErrors('service_rating');

        $this->submitForm(EateryCreateReviewRequestFactory::new()->fullReview()->state(['service_rating' => 'foo'])->create())
            ->assertSessionHasErrors('service_rating');
    }

    /** @test */
    public function itErrorsWithoutAnInvalidHowExpensiveField(): void
    {
        $this->submitForm(EateryCreateReviewRequestFactory::new(['how_expensive' => 'foo'])->create())
            ->assertSessionHasErrors('how_expensive');

        $this->submitForm(EateryCreateReviewRequestFactory::new(['how_expensive' => true])->create())
            ->assertSessionHasErrors('how_expensive');

        $this->submitForm(EateryCreateReviewRequestFactory::new(['how_expensive' => -1])->create())
            ->assertSessionHasErrors('how_expensive');

        $this->submitForm(EateryCreateReviewRequestFactory::new(['how_expensive' => 6])->create())
            ->assertSessionHasErrors('how_expensive');
    }

    /** @test */
    public function itErrorsIfSubmittingMoreThan6Images(): void
    {
        $this->submitForm(EateryCreateReviewRequestFactory::new(['images' => [1, 2, 3, 4, 5, 6, 7]])->create())
            ->assertSessionHasErrors('images');
    }

    /** @test */
    public function itErrorsIfAnImageDoesntExistInTheTable(): void
    {
        $this->submitForm(EateryCreateReviewRequestFactory::new(['images' => [1]])->create())
            ->assertSessionHasErrors('images.0');
    }

    protected function submitForm(array $data): TestResponse
    {
        return $this->post(
            route('eating-out.show.reviews.create', ['county' => $this->county, 'town' => $this->town, 'eatery' => $this->eatery->slug]),
            $data
        );
    }

    /** @test */
    public function itReturnsOkForRatingWithoutAReview(): void
    {
        $this->submitForm(EateryCreateReviewRequestFactory::new()->create())->assertSessionHasNoErrors();
    }

    /** @test */
    public function itCallsTheCreateEateryReviewAction(): void
    {
        $this->expectAction(CreateEateryReviewAction::class);

        $this->submitForm(EateryCreateReviewRequestFactory::new(['rating' => 5])->create());

    }

    /** @test */
    public function itCreatesAStandardRatingThatIsApproved(): void
    {
        $this->assertEmpty($this->eatery->reviews);

        $this->submitForm(EateryCreateReviewRequestFactory::new(['rating' => 5])->create());

        $this->assertNotEmpty($this->eatery->refresh()->reviews);

        $review = EateryReview::query()->withoutGlobalScopes()->first();

        $this->assertTrue($review->approved);
        $this->assertEquals(5, $review->rating);
        $this->assertEquals('', $review->name);
    }

    /** @test */
    public function itCreatesAFullRatingThatIsNotApproved(): void
    {
        $this->assertEmpty($this->eatery->reviews);

        $this->withoutExceptionHandling();

        $this->submitForm(EateryCreateReviewRequestFactory::new()
            ->fullReview()
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
}
