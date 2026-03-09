<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // UserSeeder::class,
            AdminSeeder::class,
            PermissionSeeder::class,
            SettingSeeder::class,
            CategorySeeder::class,
            OfferSeeder::class,
            SliderSeeder::class,
            ProductBrandSeeder::class,
            PageSeeder::class,
            CountrySeeder::class,
            CitySeeder::class,
            GovernorateCitySeeder::class,
            PaymentMethodSeeder::class,
            CouponSeeder::class,
            OptionSeeder::class,
            ShippingRuleSeeder::class,
            FlashSaleSeeder::class,
            ProductSeeder::class,
            OrderSeeder::class,
            CurrencySeeder::class,
            AdvertisementSeeder::class,
            OrderServiceSeeder::class,
            PermissionSeeder::class,
            BlogSeeder::class,
            StaticTranslationSqlSeeder::class,
        ]);

    }
}
