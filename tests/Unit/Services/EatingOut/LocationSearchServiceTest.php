<?php

declare(strict_types=1);

namespace Tests\Unit\Services\EatingOut;

use App\Services\EatingOut\LocationSearchService;
use Tests\TestCase;

class LocationSearchServiceTest extends TestCase
{
    /** @test */
    public function itCanGetTheLatLngForAResult(): void
    {
        $london = ['lat' => 51.5, 'lng' => -0.1];

        $latLng = app(LocationSearchService::class)->getLatLng('London');

        $this->assertEquals($london['lat'], round($latLng->lat, 1));
        $this->assertEquals($london['lng'], round($latLng->lng, 1));
    }
}
