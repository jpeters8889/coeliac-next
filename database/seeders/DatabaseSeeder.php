<?php

declare(strict_types=1);

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Modules\EatingOut\Models\EateryCountry;
use App\Modules\EatingOut\Models\EateryCounty;
use App\Modules\EatingOut\Models\EateryCuisine;
use App\Modules\EatingOut\Models\EateryTown;
use App\Modules\EatingOut\Models\EateryType;
use App\Modules\EatingOut\Models\EateryVenueType;
use Database\Factories\Factory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        //        Factory::factoryForModel(User::class)
        //            ->asAdmin()
        //            ->create(['email' => 'contact@coeliacsanctuary.co.uk']);

        $modelsToCreate = [
            EateryCountry::class,
            EateryCounty::class,
            EateryTown::class,
            EateryType::class,
            EateryVenueType::class,
            EateryCuisine::class,
        ];

        foreach ($modelsToCreate as $model) {
            Factory::factoryForModel($model)->create(['id' => 1]);
        }
        //
        //        ShopOrderState::query()
        //            ->insert([
        //                ['state' => 'Basket'],
        //                ['state' => 'Order'],
        //                ['state' => 'Processing'],
        //                ['state' => 'Shipped'],
        //                ['state' => 'Complete'],
        //                ['state' => 'Refund'],
        //                ['state' => 'Cancelled'],
        //            ]);
        //
        //        ShopPaymentType::query()
        //            ->insert([
        //                ['type' => 'Stripe'],
        //                ['type' => 'PayPal'],
        //            ]);
        //
        //        ShopPostageCountryArea::query()
        //            ->insert([
        //                [
        //                    'area' => 'United Kingdom',
        //                    'delivery_timescale' => '1 - 2',
        //                ],
        //                [
        //                    'area' => 'Europe',
        //                    'delivery_timescale' => '3 - 5',
        //                ],
        //            ]);
        //
        //        ShopPostageCountry::query()
        //            ->insert([
        //                [
        //                    'postage_area_id' => 1,
        //                    'country' => 'United Kingdom',
        //                    'iso_code' => 'GB',
        //                ],
        //                [
        //                    'postage_area_id' => 2,
        //                    'country' => 'Republic of Ireland',
        //                    'iso_code' => 'IE',
        //                ],
        //            ]);
        //
        //        ShopShippingMethod::query()
        //            ->insert([
        //                ['shipping_method' => 'letter'],
        //                ['shipping_method' => 'parcel'],
        //            ]);
        //
        //        ShopPostagePrice::query()
        //            ->insert([
        //                [
        //                    'postage_country_area_id' => 1,
        //                    'shipping_method_id' => 1,
        //                    'max_weight' => 100,
        //                    'price' => 150,
        //                ],
        //                [
        //                    'postage_country_area_id' => 1,
        //                    'shipping_method_id' => 1,
        //                    'max_weight' => 200,
        //                    'price' => 250,
        //                ],
        //                [
        //                    'postage_country_area_id' => 2,
        //                    'shipping_method_id' => 1,
        //                    'max_weight' => 100,
        //                    'price' => 300,
        //                ],
        //            ]);
    }
}
