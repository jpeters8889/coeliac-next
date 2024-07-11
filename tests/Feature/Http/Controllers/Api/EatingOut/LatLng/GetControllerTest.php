<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\EatingOut\LatLng;

use Spatie\Geocoder\Geocoder;
use Tests\TestCase;

class GetControllerTest extends TestCase
{
    /** @test */
    public function itErrorsWithOutATerm(): void
    {
        $this->postJson(route('api.wheretoeat.lat-lng'))->assertJsonValidationErrorFor('term');
    }

    /** @test */
    public function itReturnsTheLatLng(): void
    {
        $this->mock(Geocoder::class)
            ->shouldReceive('getCoordinatesForAddress')
            ->andReturn(['lat' => 51, 'lng' => -1])
            ->once();

        $this->postJson(route('api.wheretoeat.lat-lng'), ['term' => 'foo'])
            ->assertJson(['lat' => 51, 'lng' => -1]);
    }
}
