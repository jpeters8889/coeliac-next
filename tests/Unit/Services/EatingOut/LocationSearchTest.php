<?php

declare(strict_types=1);

namespace Tests\Unit\Services\EatingOut;

use App\DataObjects\EatingOut\LatLng;
use App\Services\EatingOut\LocationSearch;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use RuntimeException;
use Tests\TestCase;

class LocationSearchTest extends TestCase
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

        app(LocationSearch::class)->search('foo');
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

        app(LocationSearch::class)->search('foo');
    }

    /** @test */
    public function itThrowsAnExceptionIfTheRequestFails(): void
    {
        Http::fake(['*' => Http::response(status: 500)]);

        $this->expectException(RuntimeException::class);
        app(LocationSearch::class)->search('foo');

        Http::fake(['*' => Http::response(status: 400)]);

        $this->expectException(RuntimeException::class);
        app(LocationSearch::class)->search('bar');
    }

    /** @test */
    public function itReturnsTheResponseOfTheRequestAsALatLngInstance(): void
    {
        $data = ['lat' => 51.50, 'lng' => 0.12, 'display_name' => 'bar'];

        Http::fake(['*' => Http::response([$data])]);

        $latLng = app(LocationSearch::class)->search('foo');

        $this->assertInstanceOf(LatLng::class, $latLng);
        $this->assertEquals($data['lat'], $latLng->lat);
        $this->assertEquals($data['lng'], $latLng->lng);
        $this->assertEquals($data['display_name'], $latLng->label);
    }
}
