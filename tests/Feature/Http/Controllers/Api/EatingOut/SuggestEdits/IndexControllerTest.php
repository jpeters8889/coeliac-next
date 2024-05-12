<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\EatingOut\SuggestEdits;

use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\EateryCounty;
use App\Models\EatingOut\EateryFeature;
use App\Models\EatingOut\EateryTown;
use Database\Seeders\EateryScaffoldingSeeder;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class IndexControllerTest extends TestCase
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
        $this->get(route('api.wheretoeat.suggest-edit.get', ['eatery' => 'foo']))->assertNotFound();
    }

    /** @test */
    public function itReturnsNotFoundForAnEateryThatIsNotLive(): void
    {
        $eatery = $this->build(Eatery::class)->notLive()->create();

        $this->get(route('api.wheretoeat.suggest-edit.get', ['eatery' => $eatery->id]))->assertNotFound();
    }

    /** @test */
    public function itReturnsTheResponseWrappedInADataObject(): void
    {
        $this->makeRequest()->assertJsonStructure(['data']);
    }

    /** @test */
    public function itReturnsTheRequiredEateryAttributes(): void
    {
        $response = $this->makeRequest()->json('data');

        $keys = [
            'address', 'website', 'gf_menu_link', 'phone', 'type_id', 'venue_type',
            'cuisine', 'opening_times', 'features', 'is_nationwide',
        ];

        $this->assertArrayHasKeys($keys, $response);
    }

    /** @test */
    public function itReturnsTheVenueObject(): void
    {
        $venueType = $this->makeRequest()->json('data.venue_type');

        $this->assertArrayHasKeys(['id', 'label', 'values'], $venueType);

        $venueTypeKeys = ['value', 'label', 'selected'];

        foreach ($venueType['values'] as $venueTypeValue) {
            $this->assertArrayHasKeys($venueTypeKeys, $venueTypeValue);
        }
    }

    /** @test */
    public function itReturnsTheCuisineObject(): void
    {
        $Cuisine = $this->makeRequest()->json('data.cuisine');

        $this->assertArrayHasKeys(['id', 'label', 'values'], $Cuisine);

        $CuisineKeys = ['value', 'label', 'selected'];

        foreach ($Cuisine['values'] as $CuisineValue) {
            $this->assertArrayHasKeys($CuisineKeys, $CuisineValue);
        }
    }

    /** @test */
    public function itReturnsTheFeaturesObject(): void
    {
        $this->eatery->features()->attach($this->create(EateryFeature::class));

        $features = $this->makeRequest()->json('data.features');

        $this->assertArrayHasKeys(['selected', 'values'], $features);

        foreach ($features['selected'] as $feature) {
            $this->assertArrayHasKeys(['id', 'label'], $feature);
        }

        $featureKeys = ['id', 'label', 'selected'];

        foreach ($features['values'] as $feature) {
            $this->assertArrayHasKeys($featureKeys, $feature);
        }
    }

    protected function makeRequest(): TestResponse
    {
        return $this->getJson(route('api.wheretoeat.suggest-edit.get', ['eatery' => $this->eatery->id]));
    }
}
