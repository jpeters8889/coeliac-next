<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\EatingOut\Api;

use App\DataObjects\EatingOut\LatLng;
use App\Services\EatingOut\LocationSearchService;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class EatingOutBrowseSearchTest extends TestCase
{
    protected function makeRequest(?string $term = null): TestResponse
    {
        return $this->postJson(route('api.wheretoeat.browse.search', ['term' => $term]));
    }

    /** @test */
    public function itReturnsAnErrorWithoutASearchTerm(): void
    {
        $this->makeRequest(null)->assertJsonValidationErrorFor('term');
    }

    /** @test */
    public function itReturnsAnErrorIfTheSearchTermIsTooShort(): void
    {
        $this->makeRequest('ab')->assertJsonValidationErrorFor('term');
    }

    /** @test */
    public function itReturnsOk(): void
    {
        $london = ['lat' => 51.5, 'lng' => -0.1];

        $this->mock(LocationSearchService::class)
            ->expects('getLatLng')
            ->zeroOrMoreTimes()
            ->andReturn(new LatLng($london['lat'], $london['lng']));

        $this->makeRequest('london')->assertOk();
    }

    /** @test */
    public function itReturnsTheLatLngForAResponse(): void
    {
        $london = ['lat' => 51.5, 'lng' => -0.1];

        $this->mock(LocationSearchService::class)
            ->expects('getLatLng')
            ->zeroOrMoreTimes()
            ->andReturn(new LatLng($london['lat'], $london['lng']));

        $response = $this->makeRequest('london')->json();

        $this->assertEquals(round($response['lat'], 1), $london['lat']);
        $this->assertEquals(round($response['lng'], 1), $london['lng']);
    }
}
