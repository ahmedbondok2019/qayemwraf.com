<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\CategoryTranslation;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'en' => [
                    'title' => 'Standard & Light Storage Shelving',
                    'description' => 'Standard metal shelving units with 5 shelves, 92x42 cm, height 2m, including bolts, nuts, and 8 corner gusset plates. Various weight capacities from 30kg to 200kg per shelf.',
                ],
                'ar' => [
                    'title' => 'وحدات أرفف تخزين خفيفة ومتوسطة',
                    'description' => 'وحدات أرفف معدنية قياسية 5 أرفف مقاس 92×42 سم وارتفاع 2 متر، شاملة المسامير والصواميل وعدد 8 مثلثات تثبيت. بحمولات متعددة تبدأ من 30 كجم وحتى 200 كجم للرف الواحد.',
                ],
                'children' => [
                    [
                        'en' => ['title' => 'Standard Shelving Units (5 Shelves)', 'description' => 'Ready stock 5-shelf metal units in various capacities and colors.'],
                        'ar' => ['title' => 'وحدات أرفف قياسية (5 أرفف)', 'description' => 'وحدات أرفف بضاعة حاضرة 5 أرفف بحمولات وألوان متعددة.'],
                    ],
                    [
                        'en' => ['title' => 'Custom & Individual Shelves', 'description' => 'Individual shelf panels in various depths (30cm, 60cm) and heavy duty specs.'],
                        'ar' => ['title' => 'أرفف ومقاسات خاصة', 'description' => 'بلاطات أرفف مفردة بأعماق مختلفة (30 سم، 60 سم) ومقاسات محملة.'],
                    ],
                ]
            ],
            [
                'en' => [
                    'title' => 'Medium Duty Racking Units',
                    'description' => 'Medium duty shelving and storage racking units (Light Medium) - 250kg capacity per level. Available in 3 and 4 levels with heights up to 2.5m.',
                ],
                'ar' => [
                    'title' => 'وحدات تخزين ميدي ديوتي (لايت ميدي)',
                    'description' => 'وحدات تخزين ورفوف ميدي ديوتي حمولة 250 كجم للمستوى الواحد. متوفرة بـ 3 و 4 مستويات وبارتفاعات حتى 2.5 متر، متصلة أو منفصلة وبضاعة حاضرة.',
                ],
                'children' => []
            ],
            [
                'en' => [
                    'title' => 'Heavy Duty Racking Units',
                    'description' => 'Heavy duty warehouse storage racking units - 500kg load capacity per level. Heavy 1.5mm uprights, 8-fold reinforced beams, and 1mm / 0.8mm decking.',
                ],
                'ar' => [
                    'title' => 'وحدات تخزين هيفي ديوتي (مخازن ثقيلة)',
                    'description' => 'وحدات أرفف ومخازن هيفي ديوتي حمولة 500 كجم للمستوى. قوايم 1.5 مم وعوارض 1.25 مم معصبة بـ 8 تنايات وبلاطات محملة بدعامات، وحدات متصلة أو منفصلة.',
                ],
                'children' => []
            ],
            [
                'en' => [
                    'title' => 'Metal Cabinets, Lockers & Filing Units',
                    'description' => 'Heavy-duty electrostatic powder coated metal document cabinets, multi-door employee lockers, and wooden/metal filing drawer cabinets.',
                ],
                'ar' => [
                    'title' => 'دواليب ولوكرات معدنية وشانونات',
                    'description' => 'دواليب مستندات معدنية مدهونة إلكتروستاتيك، ولوكرات عمال وموظفين متعددة الضلف بكوالين، وشانونات حفظ ملفات خشب ومعدن.',
                ],
                'children' => [
                    [
                        'en' => ['title' => 'Document Cabinets', 'description' => '2-door metal document cabinets with adjustable shelves.'],
                        'ar' => ['title' => 'دواليب مستندات', 'description' => 'دواليب حفظ مستندات وأرشيف 2 ضلفة بأرفف متحركة.'],
                    ],
                    [
                        'en' => ['title' => 'Metal Lockers', 'description' => 'Heavy duty and commercial multi-door lockers with keys and accessories.'],
                        'ar' => ['title' => 'لوكرات معدنية', 'description' => 'لوكرات حفظ أمانات وملابس 2 و 4 و 6 ضلفة بكوالين وإكسسوارات.'],
                    ],
                    [
                        'en' => ['title' => 'Filing Cabinets (Shanons)', 'description' => '4-drawer metal and wood filing cabinets.'],
                        'ar' => ['title' => 'شانونات حفظ ملفات', 'description' => 'شانونات معدنية وخشبية 4 أدراج للأرشيف والملفات.'],
                    ],
                ]
            ],
            [
                'en' => [
                    'title' => 'Shelving Components & Accessories',
                    'description' => 'Individual slotted angle upright posts, metal shelves with brackets, wire mesh shelves, and mounting hardware.',
                ],
                'ar' => [
                    'title' => 'أرفف وقوائم واكسسوارات منفصلة',
                    'description' => 'قوائم حديد مثقبة مفردة، أرفف بالكوابيل، أرفف شبك سلك، ودعامات ومسامير تثبيت للأرفف.',
                ],
                'children' => []
            ],
        ];

        foreach ($categories as $catIndex => $catData) {
            $parent = Category::create([
                'parent_id' => null,
                'image' => '/_fixed/categories.jpg',
                'is_active' => true,
                'sort_order' => $catIndex,
            ]);

            foreach (['en', 'ar'] as $locale) {
                CategoryTranslation::create([
                    'category_id' => $parent->id,
                    'locale' => $locale,
                    'title' => $catData[$locale]['title'],
                    'description' => $catData[$locale]['description'],
                    'slug' => Str::slug($catData['en']['title'] . '-' . $locale . '-' . $parent->id),
                    'meta_title' => $catData[$locale]['title'],
                    'meta_description' => $catData[$locale]['description'],
                    'meta_keywords' => str_replace(' ', ',', $catData[$locale]['title']),
                ]);
            }

            if (!empty($catData['children'])) {
                foreach ($catData['children'] as $childIndex => $childData) {
                    $child = Category::create([
                        'parent_id' => $parent->id,
                        'image' => '/_fixed/subcategories.jpg',
                        'is_active' => true,
                        'sort_order' => $childIndex,
                    ]);

                    foreach (['en', 'ar'] as $locale) {
                        CategoryTranslation::create([
                            'category_id' => $child->id,
                            'locale' => $locale,
                            'title' => $childData[$locale]['title'],
                            'description' => $childData[$locale]['description'],
                            'slug' => Str::slug($childData['en']['title'] . '-' . $locale . '-' . $child->id),
                            'meta_title' => $childData[$locale]['title'],
                            'meta_description' => $childData[$locale]['description'],
                            'meta_keywords' => str_replace(' ', ',', $childData[$locale]['title']),
                        ]);
                    }
                }
            }
        }
    }
}
