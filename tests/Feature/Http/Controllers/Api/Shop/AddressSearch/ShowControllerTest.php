<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\Shop\AddressSearch;

use PHPUnit\Framework\Attributes\Test;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ShowControllerTest extends TestCase
{
    #[Test]
    public function itCallsTheGeoAddressService(): void
    {
        Http::preventStrayRequests();
        Http::fake([
            '*' => Http::response([]),
        ]);

        $this->getJson(route('api.shop.address-search.get', ['id' => 'foo']))->assertOk();

        Http::assertSent(function (Request $request) {
            $this->assertEquals('GET', $request->method());
            $this->assertStringContainsString(config('services.getAddress.url'), $request->url());
            $this->assertStringContainsString('/get/foo', $request->url());

            return true;
        });
    }

    #[Test]
    public function itReturnsTheAddressFormatted(): void
    {
        Http::preventStrayRequests();
        Http::fake([ // from https://documentation.getaddress.io/
            '*' => Http::response([
                'postcode' => 'NN1 3ER',
                'latitude' => 52.24593734741211,
                'longitude' => -0.891636312007904,
                'formatted_address' => [
                    '10 Watkin Terrace',
                    '',
                    '',
                    'Northampton',
                    'Northamptonshire',
                ],
                'thoroughfare' => 'Watkin Terrace',
                'building_name' => '',
                'sub_building_name' => '',
                'sub_building_number' => '',
                'building_number' => '10',
                'line_1' => '10 Watkin Terrace',
                'line_2' => '',
                'line_3' => '',
                'line_4' => '',
                'locality' => '',
                'town_or_city' => 'Northampton',
                'county' => 'Northamptonshire',
                'district' => 'Northampton',
                'country' => 'England',
                'residential' => true,
            ]),
        ]);

        $this->getJson(route('api.shop.address-search.get', ['id' => 'foo']))->assertOk()
            ->assertJson([
                'address_1' => '10 Watkin Terrace',
                'address_2' => '',
                'address_3' => '',
                'town' => 'Northampton',
                'county' => 'Northamptonshire',
                'postcode' => 'NN1 3ER',
            ]);
    }

    #[Test]
    public function itConcatsLine3And4IfPresent(): void
    {
        Http::preventStrayRequests();
        Http::fake([ // from https://documentation.getaddress.io/
            '*' => Http::response([
                'postcode' => 'NN1 3ER',
                'line_1' => '10 Watkin Terrace',
                'line_2' => 'foo',
                'line_3' => 'bar',
                'line_4' => 'baz',
                'town_or_city' => 'Northampton',
                'county' => 'Northamptonshire',
                'country' => 'England',
            ]),
        ]);

        $this->getJson(route('api.shop.address-search.get', ['id' => 'foo']))->assertOk()
            ->assertJsonFragment([
                'address_3' => 'bar, baz',
            ]);
    }
}
