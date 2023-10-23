<?php

declare(strict_types=1);

namespace Tests\Unit\Services\EatingOut;

use App\DataObjects\EatingOut\LatLng;
use App\Services\EatingOut\LocationSearchService;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use RuntimeException;
use Tests\TestCase;

class LocationSearchServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Http::preventStrayRequests();
    }

    /** @test */
    public function itPassesTheSearchTermInTheQueryStringParams(): void
    {
        Http::fake(function (Request $request) {
            $queryStrings = $request->data();

            $this->assertArrayHasKey('q', $queryStrings);
            $this->assertEquals('foo', $queryStrings['q']);

            return Http::response([['lat' => 1, 'lng' => 1, 'display_name' => 'bar']]);
        });

        app(LocationSearchService::class)->search('foo');
    }

    /** @test */
    public function itPassesTheCountryCodesInTheQueryStringParams(): void
    {
        Http::fake(function (Request $request) {
            $queryStrings = $request->data();

            $this->assertArrayHasKey('countryCodes', $queryStrings);
            $this->assertEquals('gb,ie', $queryStrings['countryCodes']);

            return Http::response([['lat' => 1, 'lng' => 1, 'display_name' => 'bar']]);
        });

        app(LocationSearchService::class)->search('foo');
    }

    /** @test */
    public function itThrowsAnExceptionIfTheRequestFails(): void
    {
        Http::fake(['*' => Http::response(status: 500)]);

        $this->expectException(RuntimeException::class);
        app(LocationSearchService::class)->search('foo');

        Http::fake(['*' => Http::response(status: 400)]);

        $this->expectException(RuntimeException::class);
        app(LocationSearchService::class)->search('bar');
    }

    /** @test */
    public function itReturnsEachItemAsALatLngInstance(): void
    {
        $london = ['lat' => 51.50, 'lng' => 0.12, 'display_name' => 'London'];
        $edinburgh = ['lat' => 55.95, 'lng' => -3.18, 'display_name' => 'Edinburgh'];

        Http::fake(['*' => Http::response([$london, $edinburgh])]);

        $results = collect(app(LocationSearchService::class)->search('foo'));

        $this->assertInstanceOf(LatLng::class, $results[0]);
        $this->assertEquals($london['lat'], $results[0]->lat);
        $this->assertEquals($london['lng'], $results[0]->lng);
        $this->assertEquals($london['display_name'], $results[0]->label);

        $this->assertInstanceOf(LatLng::class, $results[1]);
        $this->assertEquals($edinburgh['lat'], $results[1]->lat);
        $this->assertEquals($edinburgh['lng'], $results[1]->lng);
        $this->assertEquals($edinburgh['display_name'], $results[1]->label);
    }

    /** @test */
    public function itCanGetTheLatLngForAResult(): void
    {
        $london = ['lat' => 51.50, 'lng' => 0.12, 'display_name' => 'London'];
        $edinburgh = ['lat' => 55.95, 'lng' => -3.18, 'display_name' => 'Edinburgh'];

        Http::fake(['*' => Http::response([$london, $edinburgh])]);

        $latLng = app(LocationSearchService::class)->getLatLng('foo');

        $this->assertEquals($london['lat'], $latLng->lat);
        $this->assertEquals($london['lng'], $latLng->lng);
        $this->assertEquals($london['display_name'], $latLng->label);
    }
}
