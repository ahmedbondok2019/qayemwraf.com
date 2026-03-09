<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\CountryTranslation;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
            [
                'code' => 'EG',
                'phone_code' => '+20',
                'sort_order' => 1,
                'en' => 'Egypt',
                'ar' => 'مصر',
            ],
            [
                'code' => 'SA',
                'phone_code' => '+966',
                'sort_order' => 2,
                'en' => 'Saudi Arabia',
                'ar' => 'السعودية',
            ],
            [
                'code' => 'AE',
                'phone_code' => '+971',
                'sort_order' => 3,
                'en' => 'United Arab Emirates',
                'ar' => 'الإمارات',
            ],
            [
                'code' => 'KW',
                'phone_code' => '+965',
                'sort_order' => 4,
                'en' => 'Kuwait',
                'ar' => 'الكويت',
            ],
            [
                'code' => 'US',
                'phone_code' => '+1',
                'sort_order' => 5,
                'en' => 'United States',
                'ar' => 'الولايات المتحدة',
            ],
        ];

        foreach ($countries as $data) {
            $country = Country::create([
                'code' => $data['code'],
                'phone_code' => $data['phone_code'],
                'sort_order' => $data['sort_order'],
                'image' => null, // You can add flags here later
                'is_active' => true,
            ]);

            CountryTranslation::create([
                'country_id' => $country->id,
                'locale' => 'en',
                'name' => $data['en'],
            ]);

            CountryTranslation::create([
                'country_id' => $country->id,
                'locale' => 'ar',
                'name' => $data['ar'],
            ]);
        }
    }
}
