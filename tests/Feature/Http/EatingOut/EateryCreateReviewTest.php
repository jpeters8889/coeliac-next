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

    protected function route(string $county = null, string $town = null, string $eatery = null): string
    {
        return route('eating-out.show.reviews.create', [
            'county' => $county ?? $this->county->slug,
            'town' => $town ?? $this->town->slug,
            'eatery' => $eatery ?? $this->eatery->slug,
        ]);
    }

    protected function data(array $data = []): EateryCreateReviewRequestFactory
    {
        return EateryCreateReviewRequestFactory::new($data);
    }

    /** @test */
    public function itReturnsNotFoundForAnEateryThatDoesntExist(): void
    {
        $this->post($this->route(eatery: 'foo'))->assertNotFound();
    }

    /** @test */
    public function itReturnsNotFoundForAnEateryThatIsNotLive(): void
    {
        $eatery = $this->build(Eatery::class)->notLive()->create();

        $this->post($this->route(eatery: $eatery->slug))->assertNotFound();
    }

    /** @test */
    public function itErrorsWithoutAnInvalidRating(): void
    {
        $this->submitForm($this->data(['rating' => null])->create())
            ->assertSessionHasErrors('rating');

        $this->submitForm($this->data(['rating' => 'foo'])->create())
            ->assertSessionHasErrors('rating');

        $this->submitForm($this->data(['rating' => true])->create())
            ->assertSessionHasErrors('rating');

        $this->submitForm($this->data(['rating' => -1])->create())
            ->assertSessionHasErrors('rating');

        $this->submitForm($this->data(['rating' => 6])->create())
            ->assertSessionHasErrors('rating');
    }

    /** @test */
    public function itFailsWithAnInvalidMethodValue(): void
    {
        $this->submitForm($this->data(['method' => null])->create())
            ->assertSessionHasErrors('method');

        $this->submitForm($this->data(['method' => 123])->create())
            ->assertSessionHasErrors('method');

        $this->submitForm($this->data(['method' => false])->create())
            ->assertSessionHasErrors('method');

        $this->submitForm($this->data(['method' => 'foo'])->create())
            ->assertSessionHasErrors('method');
    }

    /** @test */
    public function itErrorsWithoutABranchNameWhenTheEateryIsNationwide(): void
    {
        $this->eatery->county->update(['county' => 'Nationwide']);

        $this->submitForm($this->data(['branch_name' => 123])->create())
            ->assertSessionHasErrors('branch_name');

        $this->submitForm($this->data(['branch_name' => false])->create())
            ->assertSessionHasErrors('branch_name');
    }

    /** @test */
    public function itErrorsWithoutAName(): void
    {
        $this->submitForm($this->data()->state(['name' => null])->create())
            ->assertSessionHasErrors('name');

        $this->submitForm($this->data()->state(['name' => 123])->create())
            ->assertSessionHasErrors('name');

        $this->submitForm($this->data()->state(['name' => true])->create())
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function itErrorsWithoutAEmail(): void
    {
        $this->submitForm($this->data()->state(['email' => null])->create())
            ->assertSessionHasErrors('email');

        $this->submitForm($this->data()->state(['email' => 123])->create())
            ->assertSessionHasErrors('email');

        $this->submitForm($this->data()->state(['email' => true])->create())
            ->assertSessionHasErrors('email');

        $this->submitForm($this->data()->state(['email' => 'foo'])->create())
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function itErrorsWithoutAReviewField(): void
    {
        $this->submitForm($this->data()->state(['review' => null])->create())
            ->assertSessionHasErrors('review');

        $this->submitForm($this->data()->state(['review' => 123])->create())
            ->assertSessionHasErrors('review');

        $this->submitForm($this->data()->state(['review' => true])->create())
            ->assertSessionHasErrors('review');
    }

    /** @test */
    public function itErrorsWithAnInvalidFoodRatingValue(): void
    {
        $this->submitForm($this->data()->state(['food_rating' => 123])->create())
            ->assertSessionHasErrors('food_rating');

        $this->submitForm($this->data()->state(['food_rating' => true])->create())
            ->assertSessionHasErrors('food_rating');

        $this->submitForm($this->data()->state(['food_rating' => 'foo'])->create())
            ->assertSessionHasErrors('food_rating');
    }

    /** @test */
    public function itErrorsWithAnInvalidServiceRatingValue(): void
    {
        $this->submitForm($this->data()->state(['service_rating' => 123])->create())
            ->assertSessionHasErrors('service_rating');

        $this->submitForm($this->data()->state(['service_rating' => true])->create())
            ->assertSessionHasErrors('service_rating');

        $this->submitForm($this->data()->state(['service_rating' => 'foo'])->create())
            ->assertSessionHasErrors('service_rating');
    }

    /** @test */
    public function itErrorsWithoutAnInvalidHowExpensiveField(): void
    {
        $this->submitForm($this->data(['how_expensive' => 'foo'])->create())
            ->assertSessionHasErrors('how_expensive');

        $this->submitForm($this->data(['how_expensive' => true])->create())
            ->assertSessionHasErrors('how_expensive');

        $this->submitForm($this->data(['how_expensive' => -1])->create())
            ->assertSessionHasErrors('how_expensive');

        $this->submitForm($this->data(['how_expensive' => 6])->create())
            ->assertSessionHasErrors('how_expensive');
    }

    /** @test */
    public function itErrorsIfSubmittingMoreThan6Images(): void
    {
        $this->submitForm($this->data(['images' => [1, 2, 3, 4, 5, 6, 7]])->create())
            ->assertSessionHasErrors('images');
    }

    /** @test */
    public function itErrorsIfAnImageDoesntExistInTheTable(): void
    {
        $this->submitForm($this->data(['images' => [1]])->create())
            ->assertSessionHasErrors('images.0');
    }

    /** @test */
    public function itReturnsOk(): void
    {
        $this->submitForm($this->data()->create())->assertSessionHasNoErrors();
    }

    /** @test */
    public function itCallsTheCreateEateryReviewAction(): void
    {
        $this->expectAction(CreateEateryReviewAction::class);

        $this->submitForm($this->data(['rating' => 5])->create());

    }

    /** @test */
    public function itCreatesAFullRatingThatIsNotApproved(): void
    {
        $this->assertEmpty($this->eatery->reviews);

        $this->submitForm($this->data()

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

    protected function submitForm(array $data): TestResponse
    {
        return $this->post($this->route(), $data);
    }
}
