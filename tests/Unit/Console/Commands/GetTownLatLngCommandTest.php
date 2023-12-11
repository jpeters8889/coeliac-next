<?php

declare(strict_types=1);

namespace Tests\Unit\Console\Commands;

use App\DataObjects\EatingOut\LatLng;
use App\Models\EatingOut\EateryCountry;
use App\Models\EatingOut\EateryCounty;
use App\Models\EatingOut\EateryTown;
use App\Services\EatingOut\LocationSearchService;
use Tests\TestCase;

class GetTownLatLngCommandTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $london = ['lat' => 51.5, 'lng' => -0.1];

        $this->create(EateryCountry::class, ['country' => 'England']);
        $this->create(EateryCounty::class, ['county' => 'Cheshire']);

        $this->mock(LocationSearchService::class)
            ->expects('getLatLng')
            ->zeroOrMoreTimes()
            ->andReturn(new LatLng($london['lat'], $london['lng']));
    }

    /** @test */
    public function itUpdatesTheLatLngOnATown(): void
    {
        $town = $this
            ->build(EateryTown::class)
            ->withoutLatLng()
            ->state(['town' => 'London'])
            ->create();

        $this->assertNull($town->latlng);

        $this->artisan('one-time:coeliac:get-town-latlng');

        $town->refresh();

        $this->assertNotNull($town->latlng);
        $this->assertEquals('51.5,-0.1', $town->latlng);
    }

    /** @test */
    public function itDoesntUpdateTheLatLngOnACTownThatAlreadyHasALatLng(): void
    {
        $town = $this
            ->build(EateryTown::class)
            ->state([
                'town' => 'London',
                'latlng' => 'foo',
            ])
            ->create();

        $this->artisan('one-time:coeliac:get-town-latlng');

        $town->refresh();

        $this->assertEquals('foo', $town->latlng);
    }
}
