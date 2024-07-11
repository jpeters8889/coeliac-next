<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\EatingOut\RecommendAPlace;

use App\Actions\EatingOut\CreatePlaceRecommendationAction;
use Database\Seeders\EateryScaffoldingSeeder;
use Illuminate\Testing\TestResponse;
use Tests\RequestFactories\EateryRecommendAPlaceApiRequestFactory;
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
        $this->makeRequest(EateryRecommendAPlaceApiRequestFactory::new()->create(['name' => null]))->assertJsonValidationErrorFor('name');
        $this->makeRequest(EateryRecommendAPlaceApiRequestFactory::new()->create(['name' => 123]))->assertJsonValidationErrorFor('name');
        $this->makeRequest(EateryRecommendAPlaceApiRequestFactory::new()->create(['name' => true]))->assertJsonValidationErrorFor('name');
    }

    /** @test */
    public function itReturnsAnErrorWithAnInvalidEmail(): void
    {
        $this->makeRequest(EateryRecommendAPlaceApiRequestFactory::new()->create(['email' => null]))->assertJsonValidationErrorFor('email');
        $this->makeRequest(EateryRecommendAPlaceApiRequestFactory::new()->create(['email' => 123]))->assertJsonValidationErrorFor('email');
        $this->makeRequest(EateryRecommendAPlaceApiRequestFactory::new()->create(['email' => true]))->assertJsonValidationErrorFor('email');
        $this->makeRequest(EateryRecommendAPlaceApiRequestFactory::new()->create(['email' => 'foo']))->assertJsonValidationErrorFor('email');
    }

    /** @test */
    public function itReturnsAnErrorWithAnInvalidPlaceName(): void
    {
        $this->makeRequest(EateryRecommendAPlaceApiRequestFactory::new()->create(['place_name' => null]))->assertJsonValidationErrorFor('place.name');
        $this->makeRequest(EateryRecommendAPlaceApiRequestFactory::new()->create(['place_name' => 123]))->assertJsonValidationErrorFor('place.name');
        $this->makeRequest(EateryRecommendAPlaceApiRequestFactory::new()->create(['place_name' => true]))->assertJsonValidationErrorFor('place.name');
    }

    /** @test */
    public function itReturnsAnErrorWithAnInvalidPlaceLocation(): void
    {
        $this->makeRequest(EateryRecommendAPlaceApiRequestFactory::new()->create(['place_location' => null]))->assertJsonValidationErrorFor('place.location');
        $this->makeRequest(EateryRecommendAPlaceApiRequestFactory::new()->create(['place_location' => 123]))->assertJsonValidationErrorFor('place.location');
        $this->makeRequest(EateryRecommendAPlaceApiRequestFactory::new()->create(['place_location' => true]))->assertJsonValidationErrorFor('place.location');
    }

    /** @test */
    public function itReturnsAnErrorWithAnInvalidPlaceUrl(): void
    {
        $this->makeRequest(EateryRecommendAPlaceApiRequestFactory::new()->create(['place_web_address' => 'foo']))->assertJsonValidationErrorFor('place.url');
        $this->makeRequest(EateryRecommendAPlaceApiRequestFactory::new()->create(['place_web_address' => 123]))->assertJsonValidationErrorFor('place.url');
        $this->makeRequest(EateryRecommendAPlaceApiRequestFactory::new()->create(['place_web_address' => true]))->assertJsonValidationErrorFor('place.url');
    }

    /** @test */
    public function itReturnsAnErrorWithAnInvalidPlaceVenueType(): void
    {
        $this->makeRequest(EateryRecommendAPlaceApiRequestFactory::new()->create(['place_venue_type_id' => 'foo']))->assertJsonValidationErrorFor('place.venueType');
        $this->makeRequest(EateryRecommendAPlaceApiRequestFactory::new()->create(['place_venue_type_id' => 123]))->assertJsonValidationErrorFor('place.venueType');
        $this->makeRequest(EateryRecommendAPlaceApiRequestFactory::new()->create(['place_venue_type_id' => true]))->assertJsonValidationErrorFor('place.venueType');
    }

    /** @test */
    public function itReturnsAnErrorWithAnInvalidPlaceDetails(): void
    {
        $this->makeRequest(EateryRecommendAPlaceApiRequestFactory::new()->create(['place_details' => null]))->assertJsonValidationErrorFor('place.details');
        $this->makeRequest(EateryRecommendAPlaceApiRequestFactory::new()->create(['place_details' => 123]))->assertJsonValidationErrorFor('place.details');
        $this->makeRequest(EateryRecommendAPlaceApiRequestFactory::new()->create(['place_details' => true]))->assertJsonValidationErrorFor('place.details');
    }

    /** @test */
    public function itCallsTheCreateRecommendedPlaceAction(): void
    {
        $this->expectAction(CreatePlaceRecommendationAction::class);

        $this->makeRequest(EateryRecommendAPlaceApiRequestFactory::new()->create())->assertJson(['data' => 'ok']);
    }

    protected function makeRequest(array $data): TestResponse
    {
        return $this->postJson(route('api.wheretoeat.recommend-a-place.store'), $data);
    }
}
