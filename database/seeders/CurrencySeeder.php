<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\CurrencyTranslation;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencies = [
            [
                'code' => 'EGP',
                'exchange_rate' => 1.0,
                'is_default' => 1,
                'status' => 1,
                'translations' => [
                    'ar' => ['name' => 'جنيه مصري', 'symbol' => 'ج.م'],
                    'en' => ['name' => 'Egyptian Pound', 'symbol' => 'EGP'],
                ],
            ],
            [
                'code' => 'USD',
                'exchange_rate' => 50.0,
                'is_default' => 0,
                'status' => 1,
                'translations' => [
                    'ar' => ['name' => 'دولار أمريكي', 'symbol' => '$'],
                    'en' => ['name' => 'US Dollar', 'symbol' => '$'],
                ],
            ],
            [
                'code' => 'SAR',
                'exchange_rate' => 13.3,
                'is_default' => 0,
                'status' => 1,
                'translations' => [
                    'ar' => ['name' => 'ريال سعودي', 'symbol' => 'ر.س'],
                    'en' => ['name' => 'Saudi Riyal', 'symbol' => 'SAR'],
                ],
            ],
        ];

        foreach ($currencies as $data) {
            $translations = $data['translations'];
            unset($data['translations']);

            $currency = Currency::updateOrCreate(
                ['code' => $data['code']],
                $data
            );

            foreach ($translations as $locale => $transData) {
                CurrencyTranslation::updateOrCreate(
                    [
                        'currency_id' => $currency->id,
                        'locale' => $locale,
                    ],
                    $transData
                );
            }
        }
    }
}
