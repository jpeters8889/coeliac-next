<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\EatingOut\Api;

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
        $this->makeRequest('london')->assertOk();
    }

    /** @test */
    public function itReturnsTheLatLngForAResponse(): void
    {
        $london = ['lat' => 51.5, 'lon' => -0.1, 'display_name' => 'London', 'type' => 'administrative'];

        $response = $this->makeRequest('london')->json();

        $this->assertEquals(round($response['lat'], 1), $london['lat']);
        $this->assertEquals(round($response['lng'], 1), $london['lon']);
    }
}
