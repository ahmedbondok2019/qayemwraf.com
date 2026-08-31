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
                    'en' => 'Height',
                    'ar' => 'الارتفاع',
                ],
                'values' => [
                    ['en' => '2 Meters (Standard)', 'ar' => '2 متر (الارتفاع القياسي)'],
                    ['en' => '2.5 Meters (Custom)', 'ar' => '2.5 متر (تصنيع بالطلب)'],
                    ['en' => '3 Meters (Custom)', 'ar' => '3 متر (تصنيع بالطلب)'],
                ]
            ],
            [
                'type' => 'single',
                'sort_order' => 2,
                'translations' => [
                    'en' => 'Number of Levels / Shelves',
                    'ar' => 'عدد المستويات / الأرفف',
                ],
                'values' => [
                    ['en' => '3 Levels', 'ar' => '3 مستويات'],
                    ['en' => '4 Levels', 'ar' => '4 مستويات'],
                    ['en' => '5 Shelves (Standard Unit)', 'ar' => '5 أرفف (الوحدة القياسية)'],
                    ['en' => '6 Shelves', 'ar' => '6 أرفف'],
                ]
            ],
            [
                'type' => 'single',
                'sort_order' => 3,
                'translations' => [
                    'en' => 'Color',
                    'ar' => 'اللون المعتمد للحمولة',
                ],
                'values' => [
                    ['en' => 'Light Grey', 'ar' => 'رمادي فاتح (30 كجم)', 'color_code' => '#D3D3D3'],
                    ['en' => 'Dark Grey', 'ar' => 'رمادي غامق (30/70 كجم)', 'color_code' => '#505050'],
                    ['en' => 'Blue x Off-White', 'ar' => 'أزرق × أبيض مائل للرمادي (45 كجم)', 'color_code' => '#1E3A8A'],
                    ['en' => 'Glossy Light Beige', 'ar' => 'بيج فاتح لامع (120 كجم)', 'color_code' => '#F5F5DC'],
                    ['en' => 'Orange x Light Beige', 'ar' => 'برتقالي × بيج فاتح (150 كجم)', 'color_code' => '#F97316'],
                    ['en' => 'Orange x Turquoise', 'ar' => 'برتقالي × تركواز (200 كجم)', 'color_code' => '#06B6D4'],
                    ['en' => 'Industrial Blue', 'ar' => 'أزرق صناعي (ميدي وهيفي)', 'color_code' => '#2563EB'],
                ]
            ],
            [
                'type' => 'single',
                'sort_order' => 4,
                'translations' => [
                    'en' => 'Shelf Dimensions / Depth',
                    'ar' => 'مقاس الرف والعمق',
                ],
                'values' => [
                    ['en' => '92x42 cm (Standard)', 'ar' => '92×42 سم (القياسي)'],
                    ['en' => '92x30 cm', 'ar' => '92×30 سم'],
                    ['en' => '60x60 cm', 'ar' => '60×60 سم'],
                    ['en' => '90x60 cm (Heavy Duty)', 'ar' => '90×60 سم (محمل)'],
                    ['en' => '200x60 cm (Racking)', 'ar' => '200×60 سم (ميدي / هيفي)'],
                    ['en' => '200x80 cm (Racking)', 'ar' => '200×80 سم (هيفي)'],
                ]
            ],
            [
                'type' => 'single',
                'sort_order' => 5,
                'translations' => [
                    'en' => 'Unit Configuration',
                    'ar' => 'نوع الوحدة',
                ],
                'values' => [
                    ['en' => 'Standalone Unit (Separate)', 'ar' => 'وحدة رئيسية منفصلة'],
                    ['en' => 'Connected Extension Unit', 'ar' => 'وحدة إضافية متصلة'],
                ]
            ],
        ];

        foreach ($options as $optData) {
            $option = Option::create([
                'type' => $optData['type'],
                'sort_order' => $optData['sort_order'],
            ]);

            foreach ($optData['translations'] as $locale => $name) {
                OptionTranslation::create([
                    'option_id' => $option->id,
                    'locale' => $locale,
                    'name' => $name,
                ]);
            }

            foreach ($optData['values'] as $index => $valData) {
                $optionValue = OptionValue::create([
                    'option_id' => $option->id,
                    'sort_order' => $index + 1,
                    'color_code' => $valData['color_code'] ?? null,
                ]);

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
