<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\EatingOut\Reviews;

use PHPUnit\Framework\Attributes\Test;
use App\Actions\EatingOut\CreateEateryReviewAction;
use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryReview;
use Database\Seeders\EateryScaffoldingSeeder;
use Illuminate\Testing\TestResponse;
use Tests\RequestFactories\EateryCreateReviewApiRequestFactory;
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

    #[Test]
    public function itReturnsNotFoundForAnEateryThatDoesntExist(): void
    {
        $this->postJson(route('api.wheretoeat.reviews.store', 'foo'))->assertNotFound();
    }

    #[Test]
    public function itReturnsNotFoundForAnEateryThatIsNotLive(): void
    {
        $eatery = $this->build(Eatery::class)->notLive()->create();

        $this->postJson(route('api.wheretoeat.reviews.store', $eatery))->assertNotFound();
    }

    #[Test]
    public function itErrorsWithoutAnInvalidRating(): void
    {
        $this->submitForm(EateryCreateReviewApiRequestFactory::new()->state(['rating' => null])->create())
            ->assertJsonValidationErrorFor('rating');

        $this->submitForm(EateryCreateReviewApiRequestFactory::new()->state(['rating' => 'foo'])->create())
            ->assertJsonValidationErrorFor('rating');

        $this->submitForm(EateryCreateReviewApiRequestFactory::new()->state(['rating' => true])->create())
            ->assertJsonValidationErrorFor('rating');

        $this->submitForm(EateryCreateReviewApiRequestFactory::new()->state(['rating' => -1])->create())
            ->assertJsonValidationErrorFor('rating');

        $this->submitForm(EateryCreateReviewApiRequestFactory::new()->state(['rating' => 6])->create())
            ->assertJsonValidationErrorFor('rating');
    }

    #[Test]
    public function itFailsWithAnInvalidMethodValue(): void
    {
        $this->submitForm(EateryCreateReviewApiRequestFactory::new()->state(['method' => null])->create())
            ->assertJsonValidationErrorFor('method');

        $this->submitForm(EateryCreateReviewApiRequestFactory::new()->state(['method' => 123])->create())
            ->assertJsonValidationErrorFor('method');

        $this->submitForm(EateryCreateReviewApiRequestFactory::new()->state(['method' => false])->create())
            ->assertJsonValidationErrorFor('method');

        $this->submitForm(EateryCreateReviewApiRequestFactory::new()->state(['method' => 'foo'])->create())
            ->assertJsonValidationErrorFor('method');
    }

    #[Test]
    public function itErrorsWithoutABranchNameWhenTheEateryIsNationwide(): void
    {
        $this->eatery->county->update(['county' => 'Nationwide']);

        $this->submitForm(EateryCreateReviewApiRequestFactory::new()->state(['branch_name' => 123])->create())
            ->assertJsonValidationErrorFor('branch_name');

        $this->submitForm(EateryCreateReviewApiRequestFactory::new()->state(['branch_name' => false])->create())
            ->assertJsonValidationErrorFor('branch_name');
    }

    #[Test]
    public function itErrorsWithoutAName(): void
    {
        $this->submitForm(EateryCreateReviewApiRequestFactory::new()->state(['name' => null])->create())
            ->assertJsonValidationErrorFor('name');
    }

    #[Test]
    public function itErrorsWithoutAEmail(): void
    {
        $this->submitForm(EateryCreateReviewApiRequestFactory::new()->state(['email' => null])->create())
            ->assertJsonValidationErrorFor('email');

        $this->submitForm(EateryCreateReviewApiRequestFactory::new()->state(['email' => 123])->create())
            ->assertJsonValidationErrorFor('email');

        $this->submitForm(EateryCreateReviewApiRequestFactory::new()->state(['email' => true])->create())
            ->assertJsonValidationErrorFor('email');

        $this->submitForm(EateryCreateReviewApiRequestFactory::new()->state(['email' => 'foo'])->create())
            ->assertJsonValidationErrorFor('email');
    }

    #[Test]
    public function itErrorsWithoutAReviewField(): void
    {
        $this->submitForm(EateryCreateReviewApiRequestFactory::new()->state(['comment' => null])->create())
            ->assertJsonValidationErrorFor('review');
    }

    #[Test]
    public function itErrorsWithAnInvalidFoodRatingValue(): void
    {
        $this->submitForm(EateryCreateReviewApiRequestFactory::new()->state(['food' => 123])->create())
            ->assertJsonValidationErrorFor('food_rating');

        $this->submitForm(EateryCreateReviewApiRequestFactory::new()->state(['food' => true])->create())
            ->assertJsonValidationErrorFor('food_rating');

        $this->submitForm(EateryCreateReviewApiRequestFactory::new()->state(['food' => 'foo'])->create())
            ->assertJsonValidationErrorFor('food_rating');
    }

    #[Test]
    public function itErrorsWithAnInvalidServiceRatingValue(): void
    {
        $this->submitForm(EateryCreateReviewApiRequestFactory::new()->state(['service' => 123])->create())
            ->assertJsonValidationErrorFor('service_rating');

        $this->submitForm(EateryCreateReviewApiRequestFactory::new()->state(['service' => true])->create())
            ->assertJsonValidationErrorFor('service_rating');

        $this->submitForm(EateryCreateReviewApiRequestFactory::new()->state(['service' => 'foo'])->create())
            ->assertJsonValidationErrorFor('service_rating');
    }

    #[Test]
    public function itErrorsWithoutAnInvalidHowExpensiveField(): void
    {
        $this->submitForm(EateryCreateReviewApiRequestFactory::new()->state(['expense' => 'foo'])->create())
            ->assertJsonValidationErrorFor('how_expensive');

        $this->submitForm(EateryCreateReviewApiRequestFactory::new()->state(['expense' => true])->create())
            ->assertJsonValidationErrorFor('how_expensive');

        $this->submitForm(EateryCreateReviewApiRequestFactory::new()->state(['expense' => -1])->create())
            ->assertJsonValidationErrorFor('how_expensive');

        $this->submitForm(EateryCreateReviewApiRequestFactory::new()->state(['expense' => 6])->create())
            ->assertJsonValidationErrorFor('how_expensive');
    }

    #[Test]
    public function itErrorsIfSubmittingMoreThan6Images(): void
    {
        $this->submitForm(EateryCreateReviewApiRequestFactory::new()->state(['images' => [1, 2, 3, 4, 5, 6, 7]])->create())
            ->assertJsonValidationErrorFor('images');
    }

    #[Test]
    public function itErrorsIfAnImageDoesntExistInTheTable(): void
    {
        $this->submitForm(EateryCreateReviewApiRequestFactory::new()->state(['images' => [1]])->create())
            ->assertJsonValidationErrorFor('images.0');
    }

    #[Test]
    public function itReturnsOk(): void
    {
        $this->submitForm(EateryCreateReviewApiRequestFactory::new()->create())->assertJsonMissingValidationErrors();
    }

    #[Test]
    public function itCallsTheCreateEateryReviewAction(): void
    {
        $this->expectAction(CreateEateryReviewAction::class);

        $this->submitForm(EateryCreateReviewApiRequestFactory::new()->state(['rating' => 5])->create());

    }

    #[Test]
    public function itCreatesAFullRatingThatIsNotApproved(): void
    {
        $this->assertEmpty($this->eatery->reviews);

        $this->submitForm(EateryCreateReviewApiRequestFactory::new()
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
        return $this->postJson(route('api.wheretoeat.reviews.store', $this->eatery), $data);
    }
}
