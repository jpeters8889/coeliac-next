<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\EatingOut\RecommendAPlace;

use App\Actions\EatingOut\CreatePlaceRecommendationAction;
use Database\Seeders\EateryScaffoldingSeeder;
use Illuminate\Testing\TestResponse;
use Tests\RequestFactories\EateryRecommendAPlaceRequestFactory;
use Tests\TestCase;

class StoreControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(EateryScaffoldingSeeder::class);
    }

    /** @test */
    public function itReturnsAnErrorWithAnInvalidName(): void
    {
        $this->makeRequest(EateryRecommendAPlaceRequestFactory::new()->create(['name' => null]))->assertSessionHasErrors('name');
        $this->makeRequest(EateryRecommendAPlaceRequestFactory::new()->create(['name' => 123]))->assertSessionHasErrors('name');
        $this->makeRequest(EateryRecommendAPlaceRequestFactory::new()->create(['name' => true]))->assertSessionHasErrors('name');
    }

    /** @test */
    public function itReturnsAnErrorWithAnInvalidEmail(): void
    {
        $this->makeRequest(EateryRecommendAPlaceRequestFactory::new()->create(['email' => null]))->assertSessionHasErrors('email');
        $this->makeRequest(EateryRecommendAPlaceRequestFactory::new()->create(['email' => 123]))->assertSessionHasErrors('email');
        $this->makeRequest(EateryRecommendAPlaceRequestFactory::new()->create(['email' => true]))->assertSessionHasErrors('email');
        $this->makeRequest(EateryRecommendAPlaceRequestFactory::new()->create(['email' => 'foo']))->assertSessionHasErrors('email');
    }

    /** @test */
    public function itReturnsAnErrorWithAnInvalidPlaceName(): void
    {
        $this->makeRequest(EateryRecommendAPlaceRequestFactory::new()->create(['place.name' => null]))->assertSessionHasErrors('place.name');
        $this->makeRequest(EateryRecommendAPlaceRequestFactory::new()->create(['place.name' => 123]))->assertSessionHasErrors('place.name');
        $this->makeRequest(EateryRecommendAPlaceRequestFactory::new()->create(['place.name' => true]))->assertSessionHasErrors('place.name');
    }

    /** @test */
    public function itReturnsAnErrorWithAnInvalidPlaceLocation(): void
    {
        $this->makeRequest(EateryRecommendAPlaceRequestFactory::new()->create(['place.location' => null]))->assertSessionHasErrors('place.location');
        $this->makeRequest(EateryRecommendAPlaceRequestFactory::new()->create(['place.location' => 123]))->assertSessionHasErrors('place.location');
        $this->makeRequest(EateryRecommendAPlaceRequestFactory::new()->create(['place.location' => true]))->assertSessionHasErrors('place.location');
    }

    /** @test */
    public function itReturnsAnErrorWithAnInvalidPlaceUrl(): void
    {
        $this->makeRequest(EateryRecommendAPlaceRequestFactory::new()->create(['place.url' => 'foo']))->assertSessionHasErrors('place.url');
        $this->makeRequest(EateryRecommendAPlaceRequestFactory::new()->create(['place.url' => 123]))->assertSessionHasErrors('place.url');
        $this->makeRequest(EateryRecommendAPlaceRequestFactory::new()->create(['place.url' => true]))->assertSessionHasErrors('place.url');
    }

    /** @test */
    public function itReturnsAnErrorWithAnInvalidPlaceVenueType(): void
    {
        $this->makeRequest(EateryRecommendAPlaceRequestFactory::new()->create(['place.venueType' => 'foo']))->assertSessionHasErrors('place.venueType');
        $this->makeRequest(EateryRecommendAPlaceRequestFactory::new()->create(['place.venueType' => 123]))->assertSessionHasErrors('place.venueType');
        $this->makeRequest(EateryRecommendAPlaceRequestFactory::new()->create(['place.venueType' => true]))->assertSessionHasErrors('place.venueType');
    }

    /** @test */
    public function itReturnsAnErrorWithAnInvalidPlaceDetails(): void
    {
        $this->makeRequest(EateryRecommendAPlaceRequestFactory::new()->create(['place.details' => null]))->assertSessionHasErrors('place.details');
        $this->makeRequest(EateryRecommendAPlaceRequestFactory::new()->create(['place.details' => 123]))->assertSessionHasErrors('place.details');
        $this->makeRequest(EateryRecommendAPlaceRequestFactory::new()->create(['place.details' => true]))->assertSessionHasErrors('place.details');
    }

    /** @test */
    public function itCallsTheCreateRecommendedPlaceAction(): void
    {
        $this->expectAction(CreatePlaceRecommendationAction::class);

        $this->makeRequest(EateryRecommendAPlaceRequestFactory::new()->create())->assertRedirectToRoute('eating-out.recommend.index');
    }

    protected function makeRequest(array $data): TestResponse
    {
        return $this->post(route('eating-out.recommend.create'), $data);
    }
}
