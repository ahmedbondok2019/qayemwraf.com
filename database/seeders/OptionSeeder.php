<?php

namespace Database\Seeders;

use App\Models\Option;
use App\Models\OptionTranslation;
use App\Models\OptionValue;
use App\Models\OptionValueTranslation;
use Illuminate\Database\Seeder;

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
                    ['en' => '2 Meters', 'ar' => '2 متر'],
                    ['en' => '2.5 Meters', 'ar' => '2.5 متر'],
                    ['en' => '3 Meters', 'ar' => '3 متر'],
                    ['en' => '4 Meters', 'ar' => '4 متر'],
                    ['en' => '5 Meters', 'ar' => '5 متر'],
                    ['en' => '6 Meters', 'ar' => '6 متر'],
                ],
            ],
            [
                'type' => 'single',
                'sort_order' => 2,
                'translations' => [
                    'en' => 'Depth',
                    'ar' => 'العمق',
                ],
                'values' => [
                    ['en' => '30 cm', 'ar' => '30 سم'],
                    ['en' => '40 cm', 'ar' => '40 سم'],
                    ['en' => '42 cm (Standard)', 'ar' => '42 سم (القياسي)'],
                    ['en' => '60 cm', 'ar' => '60 سم'],
                    ['en' => '80 cm', 'ar' => '80 سم'],
                    ['en' => '1.0 Meter', 'ar' => '1 متر (100 سم)'],
                    ['en' => '1.2 Meters', 'ar' => '1.2 متر (120 سم)'],
                ],
            ],
            [
                'type' => 'single',
                'sort_order' => 3,
                'translations' => [
                    'en' => 'Width / Beam Length',
                    'ar' => 'العرض / طول الكمر',
                ],
                'values' => [
                    ['en' => '92 cm', 'ar' => '92 سم'],
                    ['en' => '1.0 Meter', 'ar' => '1 متر'],
                    ['en' => '2.0 Meters', 'ar' => '2 متر'],
                    ['en' => '2.2 Meters', 'ar' => '2.2 متر'],
                    ['en' => '2.5 Meters', 'ar' => '2.5 متر'],
                    ['en' => '2.8 Meters', 'ar' => '2.8 متر'],
                ],
            ],
            [
                'type' => 'single',
                'sort_order' => 4,
                'translations' => [
                    'en' => 'Weight Capacity per Level',
                    'ar' => 'الحمولة للمستوى الواحد',
                ],
                'values' => [
                    ['en' => '30 kg / Shelf', 'ar' => '30 كجم للرف'],
                    ['en' => '45 kg / Shelf', 'ar' => '45 كجم للرف'],
                    ['en' => '70 kg / Shelf', 'ar' => '70 كجم للرف'],
                    ['en' => '120 kg / Shelf', 'ar' => '120 كجم للرف'],
                    ['en' => '150 kg / Shelf', 'ar' => '150 كجم للرف'],
                    ['en' => '200 kg / Shelf', 'ar' => '200 كجم للرف'],
                    ['en' => '250 kg / Level (Medium Duty)', 'ar' => '250 كجم للمستوى (ميدي ديوتي)'],
                    ['en' => '500 kg / Level (Heavy Duty)', 'ar' => '500 كجم للمستوى (هيفي ديوتي)'],
                    ['en' => '1 Ton (1000 kg) / Level', 'ar' => '1 طن (1000 كجم) للمستوى'],
                    ['en' => '2 Tons (2000 kg) / Level', 'ar' => '2 طن (2000 كجم) للمستوى'],
                    ['en' => '3 Tons (3000 kg) / Level', 'ar' => '3 طن (3000 كجم) للمستوى'],
                ],
            ],
            [
                'type' => 'single',
                'sort_order' => 5,
                'translations' => [
                    'en' => 'Number of Levels / Shelves',
                    'ar' => 'عدد المستويات / الأرفف',
                ],
                'values' => [
                    ['en' => '3 Levels', 'ar' => '3 مستويات'],
                    ['en' => '4 Levels', 'ar' => '4 مستويات'],
                    ['en' => '5 Shelves (Standard Unit)', 'ar' => '5 أرفف (الوحدة القياسية)'],
                    ['en' => '6 Shelves', 'ar' => '6 أرفف'],
                ],
            ],
            [
                'type' => 'single',
                'sort_order' => 6,
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
                    ['en' => 'Industrial Blue x Orange', 'ar' => 'أزرق صناعي × برتقالي (هيفي وميدي)', 'color_code' => '#2563EB'],
                ],
            ],
            [
                'type' => 'single',
                'sort_order' => 7,
                'translations' => [
                    'en' => 'Unit Configuration',
                    'ar' => 'نوع الوحدة',
                ],
                'values' => [
                    ['en' => 'Standalone Unit (Separate)', 'ar' => 'وحدة رئيسية منفصلة'],
                    ['en' => 'Connected Extension Unit', 'ar' => 'وحدة إضافية متصلة'],
                ],
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
