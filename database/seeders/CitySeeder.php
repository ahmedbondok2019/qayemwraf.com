<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Governorate;
use App\Models\GovernorateTranslation;
use App\Models\City;
use App\Models\CityTranslation;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define some additional cities for existing governorates
        $citiesData = [
            'Cairo' => [
                ['en' => 'Shorouk City', 'ar' => 'مدينة الشروق'],
                ['en' => 'Madinaty', 'ar' => 'مدينتي'],
                ['en' => 'El Rehab', 'ar' => 'الرحاب'],
                ['en' => 'Zamalek', 'ar' => 'الزمالك'],
            ],
            'Giza' => [
                ['en' => 'Sheikh Zayed', 'ar' => 'الشيخ زايد'],
                ['en' => 'Faisal', 'ar' => 'فيصل'],
                ['en' => 'Imbaba', 'ar' => 'إمبابة'],
            ],
            'Alexandria' => [
                ['en' => 'Borg El Arab', 'ar' => 'برج العرب'],
                ['en' => 'Agami', 'ar' => 'العجمي'],
            ],
        ];

        foreach ($citiesData as $govNameEn => $cities) {
            // Find governorate by English name
            // We use whereHas to query the translations
            $governorate = Governorate::whereHas('translations', function ($q) use ($govNameEn) {
                $q->where('locale', 'en')->where('name', $govNameEn);
            })->first();

            if ($governorate) {
                foreach ($cities as $cityData) {
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
}
