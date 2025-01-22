<?php

declare(strict_types=1);

namespace Tests\Unit\Console\Commands;

use PHPUnit\Framework\Attributes\Test;
use App\DataObjects\EatingOut\LatLng;
use App\Models\EatingOut\EateryCountry;
use App\Models\EatingOut\EateryCounty;
use App\Services\EatingOut\LocationSearchService;
use Tests\TestCase;

class GetCountyLatLngCommandTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $london = ['lat' => 51.5, 'lng' => -0.1];

        $this->create(EateryCountry::class, ['country' => 'England']);

        $this->mock(LocationSearchService::class)
            ->expects('getLatLng')
            ->zeroOrMoreTimes()
            ->andReturn(new LatLng($london['lat'], $london['lng']));
    }

    #[Test]
    public function itUpdatesTheLatLngOnACounty(): void
    {
        $county = $this
            ->build(EateryCounty::class)
            ->withoutLatLng()
            ->state(['county' => 'London'])
            ->create();

        $this->assertNull($county->latlng);

        $this->artisan('one-time:coeliac:get-county-latlng');

        $county->refresh();

        $this->assertNotNull($county->latlng);
        $this->assertEquals('51.5,-0.1', $county->latlng);
    }

    #[Test]
    public function itDoesntUpdateTheLatLngOnACountyThatAlreadyHasALatLng(): void
    {
        $county = $this
            ->build(EateryCounty::class)
            ->state([
                'county' => 'London',
                'latlng' => 'foo',
            ])
            ->create();

        $this->artisan('one-time:coeliac:get-county-latlng');

        $county->refresh();

        $this->assertEquals('foo', $county->latlng);
    }

    #[Test]
    public function itDoesntUpdateTheLatLngIfTheCountyIsNationwide(): void
    {
        $county = $this
            ->build(EateryCounty::class)
            ->withoutLatLng()
            ->state(['county' => 'Nationwide'])
            ->create();

        $this->assertNull($county->latlng);

        $this->artisan('one-time:coeliac:get-county-latlng');

        $county->refresh();

        $this->assertNull($county->latlng);
    }
}
