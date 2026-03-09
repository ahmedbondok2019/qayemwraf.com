<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\Governorate;
use App\Models\GovernorateTranslation;
use App\Models\City;
use App\Models\CityTranslation;

class GovernorateCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get Egypt
        $egypt = Country::where('code', 'EG')->first();

        if (!$egypt) {
            $this->command->info('Egypt country not found. Please run CountrySeeder first.');
            return;
        }

        $data = [
            [
                'en' => 'Cairo',
                'ar' => 'القاهرة',
                'cities' => [
                    ['en' => 'Nasr City', 'ar' => 'مدينة نصر'],
                    ['en' => 'Maadi', 'ar' => 'المعادي'],
                    ['en' => 'New Cairo', 'ar' => 'القاهرة الجديدة'],
                    ['en' => 'Heliopolis', 'ar' => 'مصر الجديدة'],
                ]
            ],
            [
                'en' => 'Giza',
                'ar' => 'الجيزة',
                'cities' => [
                    ['en' => '6th of October', 'ar' => '6 أكتوبر'],
                    ['en' => 'Dokki', 'ar' => 'الدقي'],
                    ['en' => 'Mohandessin', 'ar' => 'المهندسين'],
                    ['en' => 'Haram', 'ar' => 'الهرم'],
                ]
            ],
            [
                'en' => 'Alexandria',
                'ar' => 'الإسكندرية',
                'cities' => [
                    ['en' => 'Smouha', 'ar' => 'سموحة'],
                    ['en' => 'Sidi Gaber', 'ar' => 'سيدي جابر'],
                    ['en' => 'Montaza', 'ar' => 'المنتزه'],
                ]
            ],
            [
                'en' => 'Dakahlia',
                'ar' => 'الدقهلية',
                'cities' => [
                    ['en' => 'Mansoura', 'ar' => 'المنصورة'],
                    ['en' => 'Talkha', 'ar' => 'طلخا'],
                ]
            ],
             [
                'en' => 'Red Sea',
                'ar' => 'البحر الأحمر',
                'cities' => [
                    ['en' => 'Hurghada', 'ar' => 'الغردقة'],
                    ['en' => 'El Gouna', 'ar' => 'الجونة'],
                ]
            ],
        ];

        foreach ($data as $govData) {
            // Create Governorate
            $governorate = Governorate::create([
                'country_id' => $egypt->id,
                'is_active' => true,
                'sort_order' => 0,
            ]);

            GovernorateTranslation::create([
                'governorate_id' => $governorate->id,
                'locale' => 'en',
                'name' => $govData['en'],
            ]);

            GovernorateTranslation::create([
                'governorate_id' => $governorate->id,
                'locale' => 'ar',
                'name' => $govData['ar'],
            ]);

            // Create Cities
            foreach ($govData['cities'] as $cityData) {
                $city = City::create([
                    'governorate_id' => $governorate->id,
                    'is_active' => true,
                    'sort_order' => 0,
                ]);

                CityTranslation::create([
                    'city_id' => $city->id,
                    'locale' => 'en',
                    'name' => $cityData['en'],
                ]);

                CityTranslation::create([
                    'city_id' => $city->id,
                    'locale' => 'ar',
                    'name' => $cityData['ar'],
                ]);
            }
        }
    }
}
