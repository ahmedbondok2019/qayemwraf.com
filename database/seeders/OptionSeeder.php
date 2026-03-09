<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Option;
use App\Models\OptionTranslation;
use App\Models\OptionValue;
use App\Models\OptionValueTranslation;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $options = [
            [
                'type' => 'single',
                'sort_order' => 1,
                'translations' => [
                    'en' => 'Size',
                    'ar' => 'الحجم',
                ],
                'values' => [
                    ['en' => 'Pocket (10x14)', 'ar' => 'الجيب (10x14)'],
                    ['en' => 'Small (14x20)', 'ar' => 'ربع (14x20)'],
                    ['en' => 'Standard (17x24)', 'ar' => 'عادي (17x24)'],
                    ['en' => 'Large (20x28)', 'ar' => 'جوامعي (20x28)'],
                    ['en' => 'Extra Large (25x35)', 'ar' => 'تهجد (25x35)'],
                ]
            ],
            [
                'type' => 'single',
                'sort_order' => 2,
                'translations' => [
                    'en' => 'Narration',
                    'ar' => 'الرواية',
                ],
                'values' => [
                    ['en' => 'Hafs An Asim', 'ar' => 'حفص عن عاصم'],
                    ['en' => 'Warsh An Nafi', 'ar' => 'ورش عن نافع'],
                    ['en' => 'Qaloon An Nafi', 'ar' => 'قالون عن نافع'],
                    ['en' => 'Al-Duri An Abi Amr', 'ar' => 'الدوري عن أبي عمرو'],
                    ['en' => 'Shubah An Asim', 'ar' => 'شعبة عن عاصم'],
                ]
            ],
            [
                'type' => 'single',
                'sort_order' => 3,
                'translations' => [
                    'en' => 'Cover Type',
                    'ar' => 'نوع الغلاف',
                ],
                'values' => [
                    ['en' => 'Hardcover', 'ar' => 'مجلد كرتون'],
                    ['en' => 'Softcover', 'ar' => 'غلاف ورقي'],
                    ['en' => 'Leather (Thermo)', 'ar' => 'جلد ترمو'],
                    ['en' => 'Velvet', 'ar' => 'قطيفة'],
                    ['en' => 'Boxed', 'ar' => 'علبة'],
                ]
            ],
            [
                'type' => 'single',
                'sort_order' => 4,
                'translations' => [
                    'en' => 'Paper Type',
                    'ar' => 'نوع الورق',
                ],
                'values' => [
                    ['en' => 'Cream (Shamwa)', 'ar' => 'شامواه (أصفر)'],
                    ['en' => 'White', 'ar' => 'أبيض'],
                    ['en' => 'Glossy (Art)', 'ar' => 'مقصع (Art)'],
                ]
            ],
             [
                'type' => 'single', // Or multiple if user can pick options
                'sort_order' => 5,
                'translations' => [
                    'en' => 'Cover Color',
                    'ar' => 'لون الغلاف',
                ],
                'values' => [
                    ['en' => 'Green', 'ar' => 'أخضر', 'color_code' => '#008000'],
                    ['en' => 'Blue', 'ar' => 'أزرق', 'color_code' => '#0000FF'],
                    ['en' => 'Red/Maroon', 'ar' => 'أحمر/نبيتي', 'color_code' => '#800000'],
                    ['en' => 'Black', 'ar' => 'أسود', 'color_code' => '#000000'],
                    ['en' => 'Brown', 'ar' => 'بني', 'color_code' => '#A52A2A'],
                ]
            ],
        ];

        foreach ($options as $optData) {
            // Create Option
            $option = Option::create([
                'type' => $optData['type'],
                'sort_order' => $optData['sort_order'],
            ]);

            // Create Option Translations
            foreach ($optData['translations'] as $locale => $name) {
                OptionTranslation::create([
                    'option_id' => $option->id,
                    'locale' => $locale,
                    'name' => $name,
                ]);
            }

            // Create Values
            foreach ($optData['values'] as $index => $valData) {
                $optionValue = OptionValue::create([
                    'option_id' => $option->id,
                    'sort_order' => $index + 1,
                    'color_code' => $valData['color_code'] ?? null,
                ]);

                // Create Value Translations
                foreach (['en', 'ar'] as $locale) {
                    if (isset($valData[$locale])) {
                        OptionValueTranslation::create([
                            'option_value_id' => $optionValue->id,
                            'locale' => $locale,
                            'value' => $valData[$locale],
                        ]);
                    }
                }
            }
        }
    }
}
