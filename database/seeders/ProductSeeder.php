<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductTranslation;
use App\Models\Category;
use App\Models\ProductBrand;
use App\Models\ShippingRule;
use App\Models\ProductOption;
use App\Models\ProductOptionValue;
use App\Models\Option;
use App\Models\ProductImage;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brand = ProductBrand::first();
        $shippingRule = ShippingRule::first();

        // Get categories by English slug or title match
        $allCategories = Category::with('translations')->get();

        $findCategory = function ($titlePart) use ($allCategories) {
            foreach ($allCategories as $cat) {
                foreach ($cat->translations as $trans) {
                    if (stripos($trans->title, $titlePart) !== false) {
                        return $cat;
                    }
                }
            }
            return $allCategories->first();
        };

        $catStandard = $findCategory('Standard & Light') ?? $allCategories->first();
        $catMedium = $findCategory('Medium Duty') ?? $allCategories->first();
        $catHeavy = $findCategory('Heavy Duty') ?? $allCategories->first();
        $catCabinets = $findCategory('Metal Cabinets') ?? $allCategories->first();
        $catComponents = $findCategory('Shelving Components') ?? $allCategories->first();

        // Default placeholder images
        $placeholderImages = [
            '/_fixed/book1.png',
            '/_fixed/book2.png',
            '/_fixed/book3.png',
            '/_fixed/book4.png',
        ];

        $productsData = [
            // ==========================================
            // 1. وحدات أرفف قياسية (Standard Shelving Units)
            // ==========================================
            [
                'sku' => 'SH-STD-30K',
                'price' => 1050,
                'category' => $catStandard,
                'weight' => 12.0,
                'image' => '/_fixed/book1.png',
                'is_best_seller' => true,
                'show_on_home' => true,
                'ar' => [
                    'name' => 'وحدة رفوف تخزين حمولة 30 كجم للرف (5 أرفف 92×42 سم ارتفاع 2م)',
                    'description' => "وحدة رفوف تخزين معدنية متكاملة بضاعة حاضرة، تتكون من 5 أرفف مقاس 92×42 سم وارتفاع 2 متر.\nالمواصفات الفنية:\n- حمولة الرف: 30 كجم متوزعة بانتظام.\n- سمك القايم: 0.8 مم.\n- سمك الرف: 0.4 مم مع 1 دعامة تقوية.\n- اللون: رمادي فاتح أو رمادي غامق مدهون إلكتروستاتيك.\n- شامل المسامير والصواميل وعدد 8 مثلثات تثبيت لزيادة الاتزان.\n* متوفر إمكانية تصنيع ارتفاعات 2.5م و 3م ومقاسات خاصة للكميات (تبدأ من 20 وحدة).",
                ],
                'en' => [
                    'name' => 'Standard Storage Shelving Unit - 30kg/Shelf (5 Shelves 92x42cm H2m)',
                    'description' => "Ready stock complete metal storage shelving unit consisting of 5 shelves (92x42 cm) and 2m height.\nTechnical Specifications:\n- Shelf Capacity: 30 kg evenly distributed.\n- Upright Thickness: 0.8 mm.\n- Shelf Thickness: 0.4 mm with 1 reinforcement support.\n- Colors: Light Grey or Dark Grey (Electrostatic powder coating).\n- Includes all bolts, nuts, and 8 corner gusset plates for stability.\n* Custom heights (2.5m, 3m) available for bulk orders (min 20 units).",
                ],
            ],
            [
                'sku' => 'SH-STD-45K',
                'price' => 1350,
                'category' => $catStandard,
                'weight' => 14.5,
                'image' => '/_fixed/book2.png',
                'is_best_seller' => true,
                'show_on_home' => true,
                'ar' => [
                    'name' => 'وحدة رفوف تخزين حمولة 45 كجم للرف (5 أرفف 92×42 سم ارتفاع 2م)',
                    'description' => "وحدة رفوف تخزين معدنية متينة 5 أرفف مقاس 92×42 سم وارتفاع 2 متر، بضاعة حاضرة.\nالمواصفات الفنية:\n- حمولة الرف: 45 كجم.\n- سمك القايم: 1.1 مم.\n- سمك الرف: 0.5 مم مع دعامة تقوية.\n- اللون: أزرق × أبيض مائل للرمادي.\n- شامل المسامير والصواميل وعدد 8 مثلثات تثبيت.\n* بضاعة حاضرة وتسليم فوري.",
                ],
                'en' => [
                    'name' => 'Storage Shelving Unit - 45kg/Shelf (5 Shelves 92x42cm H2m)',
                    'description' => "Durable metal storage shelving unit with 5 shelves (92x42 cm) and 2m height.\nTechnical Specifications:\n- Shelf Capacity: 45 kg.\n- Upright Thickness: 1.1 mm.\n- Shelf Thickness: 0.5 mm with reinforcement rib.\n- Color: Blue x Off-White.\n- Includes all assembly hardware and 8 corner gusset plates.\n* In-stock for immediate delivery.",
                ],
            ],
            [
                'sku' => 'SH-STD-70K',
                'price' => 1750,
                'category' => $catStandard,
                'weight' => 18.0,
                'image' => '/_fixed/book3.png',
                'is_best_seller' => false,
                'show_on_home' => true,
                'ar' => [
                    'name' => 'وحدة رفوف تخزين حمولة 70 كجم للرف (5 أرفف 92×42 سم ارتفاع 2م)',
                    'description' => "وحدة أرفف معدنية قوية 5 أرفف مقاس 92×42 سم وارتفاع 2 متر.\nالمواصفات الفنية:\n- حمولة الرف: 70 كجم.\n- سمك القايم: 1.3 مم.\n- سمك الرف: 0.7 مم مع 1 دعامة تقوية.\n- اللون: رمادي غامق مدهون إلكتروستاتيك عالي الجودة.\n- شامل مسامير التجميع و 8 مثلثات اتزان.\n* بضاعة حاضرة.",
                ],
                'en' => [
                    'name' => 'Heavy-Duty Storage Shelving Unit - 70kg/Shelf (5 Shelves 92x42cm H2m)',
                    'description' => "Reinforced metal storage unit with 5 shelves (92x42 cm) and 2m height.\nTechnical Specifications:\n- Shelf Capacity: 70 kg.\n- Upright Thickness: 1.3 mm.\n- Shelf Thickness: 0.7 mm with 1 support rib.\n- Color: Dark Grey.\n- Complete with assembly hardware and 8 gusset plates.\n* In-stock item.",
                ],
            ],
            [
                'sku' => 'SH-STD-120K',
                'price' => 2200,
                'category' => $catStandard,
                'weight' => 23.0,
                'image' => '/_fixed/book4.png',
                'is_best_seller' => true,
                'show_on_home' => true,
                'ar' => [
                    'name' => 'وحدة رفوف تخزين حمولة 120 كجم للرف (5 أرفف 92×42 سم ارتفاع 2م)',
                    'description' => "وحدة رفوف تخزين محملة للأحمال العالية 5 أرفف مقاس 92×42 سم بارتفاع 2 متر.\nالمواصفات الفنية:\n- حمولة الرف: 120 كجم.\n- سمك القايم: 2 مم عالي التحمل.\n- سمك الرف: 0.8 مم مع 2 دعامة تقوية سفلية.\n- اللون: بيج فاتح لامع فاخر ومقاوم للصدأ.\n- شامل المسامير و 8 مثلثات تثبيت.\n* بضاعة حاضرة.",
                ],
                'en' => [
                    'name' => 'High-Capacity Storage Shelving Unit - 120kg/Shelf (5 Shelves 92x42cm H2m)',
                    'description' => "High-capacity heavy duty metal shelving unit with 5 shelves (92x42 cm) and 2m height.\nTechnical Specifications:\n- Shelf Capacity: 120 kg.\n- Upright Thickness: 2.0 mm heavy duty.\n- Shelf Thickness: 0.8 mm with 2 bottom support ribs.\n- Color: Glossy Light Beige (Rust-resistant coating).\n- Includes hardware and 8 corner plates.\n* In-stock.",
                ],
            ],
            [
                'sku' => 'SH-STD-150K',
                'price' => 2550,
                'category' => $catStandard,
                'weight' => 28.0,
                'image' => '/_fixed/book1.png',
                'is_best_seller' => false,
                'show_on_home' => true,
                'ar' => [
                    'name' => 'وحدة رفوف تخزين حمولة 150 كجم للرف (5 أرفف 92×42 سم ارتفاع 2م)',
                    'description' => "وحدة رفوف تخزين شاقة للأوزان الثقيلة 5 أرفف مقاس 92×42 سم بارتفاع 2 متر.\nالمواصفات الفنية:\n- حمولة الرف: 150 كجم.\n- سمك القايم: 2 مم مقاس عريض 3×7 سم.\n- سمك الرف: 0.8 مم مع 2 دعامة تقوية.\n- اللون المميز: برتقالي × بيج فاتح.\n- شامل جميع مستلزمات التجميع والمسامير و 8 مثلثات.\n* بضاعة حاضرة.",
                ],
                'en' => [
                    'name' => 'Heavy-Duty Storage Shelving Unit - 150kg/Shelf (5 Shelves 92x42cm H2m)',
                    'description' => "Heavy-duty warehouse metal shelving unit with 5 shelves (92x42 cm) and 2m height.\nTechnical Specifications:\n- Shelf Capacity: 150 kg.\n- Upright Thickness: 2.0 mm (3x7 cm wide profile).\n- Shelf Thickness: 0.8 mm with 2 support ribs.\n- Color: Orange x Light Beige.\n- Includes bolts and 8 corner gusset plates.\n* In-stock.",
                ],
            ],
            [
                'sku' => 'SH-STD-200K',
                'price' => 3100,
                'category' => $catStandard,
                'weight' => 34.0,
                'image' => '/_fixed/book2.png',
                'is_best_seller' => true,
                'show_on_home' => true,
                'ar' => [
                    'name' => 'وحدة رفوف تخزين صناعية حمولة 200 كجم للرف (5 أرفف 92×42 سم ارتفاع 2م)',
                    'description' => "أقوى وحدة رفوف معدنية في فئتها بحمولة تصل إلى 200 كجم للرف الواحد (5 أرفف 92×42 سم ارتفاع 2م).\nالمواصفات الفنية:\n- حمولة الرف: 200 كجم.\n- القايم: قايم عريض 3×7 سمك 2 مم فائق التحمل.\n- سمك الرف: 1.25 مم صاج سميك معزز.\n- اللون: برتقالي × تركواز.\n- شامل المسامير والصواميل و 8 مثلثات تثبيت.\n* بضاعة حاضرة.",
                ],
                'en' => [
                    'name' => 'Industrial Storage Shelving Unit - 200kg/Shelf (5 Shelves 92x42cm H2m)',
                    'description' => "Maximum capacity industrial shelving unit supporting up to 200kg per shelf (5 shelves 92x42cm H2m).\nTechnical Specifications:\n- Shelf Capacity: 200 kg.\n- Uprights: Wide 3x7 cm, 2.0 mm heavy steel.\n- Shelf Thickness: 1.25 mm reinforced steel panel.\n- Color: Orange x Turquoise.\n- Complete with bolts, nuts, and 8 corner plates.\n* In-stock.",
                ],
            ],

            // ==========================================
            // بلاطات أرفف مفردة ومقاسات خاصة
            // ==========================================
            [
                'sku' => 'SH-PNL-92X30',
                'price' => 190,
                'category' => $catStandard,
                'weight' => 2.5,
                'image' => '/_fixed/book3.png',
                'is_best_seller' => false,
                'show_on_home' => false,
                'ar' => [
                    'name' => 'بلاطة رف تخزين مقاس 92×30 سم حمولة 45 كجم',
                    'description' => 'بلاطة رف معدني مفردة مقاس 92 سم عرض × عمق 30 سم حمولة 45 كجم للرف، مدهونة إلكتروستاتيك مقاومة للخدش والصدأ، بضاعة حاضرة.',
                ],
                'en' => [
                    'name' => 'Metal Shelf Panel 92x30cm - 45kg Capacity',
                    'description' => 'Individual metal shelf panel 92cm width x 30cm depth with 45kg load capacity. Electrostatic powder coated, in-stock.',
                ],
            ],
            [
                'sku' => 'SH-PNL-60X60',
                'price' => 220,
                'category' => $catStandard,
                'weight' => 3.2,
                'image' => '/_fixed/book4.png',
                'is_best_seller' => false,
                'show_on_home' => false,
                'ar' => [
                    'name' => 'بلاطة رف تخزين مربع مقاس 60×60 سم',
                    'description' => 'بلاطة رف معدني مفردة مقاس 60×60 سم مربعة، مناسبة للزوايا ومساحات التخزين الخاصة، بضاعة حاضرة.',
                ],
                'en' => [
                    'name' => 'Square Metal Shelf Panel 60x60cm',
                    'description' => 'Single square metal shelf panel 60x60 cm, ideal for corners and custom storage applications.',
                ],
            ],
            [
                'sku' => 'SH-PNL-90X60',
                'price' => 290,
                'category' => $catStandard,
                'weight' => 4.5,
                'image' => '/_fixed/book1.png',
                'is_best_seller' => false,
                'show_on_home' => false,
                'ar' => [
                    'name' => 'بلاطة رف تخزين محمل مقاس 90×60 سم',
                    'description' => 'بلاطة رف تخزين معدني عريض محمل مقاس 90×60 سم للأوزان العالية والأعماق الكبيرة، بضاعة حاضرة.',
                ],
                'en' => [
                    'name' => 'Heavy-Duty Metal Shelf Panel 90x60cm',
                    'description' => 'Heavy-duty wide metal shelf panel 90x60 cm for deep storage and heavy items.',
                ],
            ],

            // ==========================================
            // 2. وحدات ميدي ديوتي (Medium Duty - لايت ميدي)
            // ==========================================
            [
                'sku' => 'MD-2X2X60-3L',
                'price' => 6000,
                'category' => $catMedium,
                'weight' => 45.0,
                'image' => '/_fixed/book2.png',
                'is_best_seller' => true,
                'show_on_home' => true,
                'ar' => [
                    'name' => 'وحدة رفوف ميدي ديوتي 3 مستويات (2م عرض × 2م ارتفاع × 60سم عمق) - حمولة 250 كجم/مستوى',
                    'description' => "وحدة تخزين ميدي ديوتي (لايت ميدي) بضاعة حاضرة للمخازن والورش والمحلات.\nالمواصفات الفنية:\n- الأبعاد: 2 متر عرض × 2 متر ارتفاع × عمق 60 سم.\n- عدد المستويات: 3 مستويات بالأرفف.\n- حمولة المستوى: 250 كجم.\n- سمك القايم: 1.0 مم.\n- سمك بلاطة الرف: 0.8 مم.\n- يمكن تركيب الوحدات بشكل منفصل أو متصل حسب المساحة.\n* بضاعة حاضرة.",
                ],
                'en' => [
                    'name' => 'Medium Duty Racking Unit - 3 Levels (2m W x 2m H x 60cm D) - 250kg/Level',
                    'description' => "Medium duty storage racking unit (Light Medium) ready in stock for warehouses, workshops, and stores.\nSpecifications:\n- Dimensions: 2m Width x 2m Height x 60cm Depth.\n- Levels: 3 Shelf Levels.\n- Capacity: 250 kg per level.\n- Upright Thickness: 1.0 mm.\n- Shelf Thickness: 0.8 mm.\n- Can be configured as standalone or connected continuous rows.\n* In-stock.",
                ],
            ],
            [
                'sku' => 'MD-2X2X60-4L',
                'price' => 7450,
                'category' => $catMedium,
                'weight' => 58.0,
                'image' => '/_fixed/book3.png',
                'is_best_seller' => true,
                'show_on_home' => true,
                'ar' => [
                    'name' => 'وحدة رفوف ميدي ديوتي 4 مستويات (2م عرض × 2م ارتفاع × 60سم عمق) - حمولة 250 كجم/مستوى',
                    'description' => "وحدة تخزين ميدي ديوتي (لايت ميدي) 4 مستويات تخزين للمخازن والشركات.\nالمواصفات الفنية:\n- الأبعاد: 2 متر عرض × 2 متر ارتفاع × عمق 60 سم.\n- عدد المستويات: 4 مستويات بالأرفف.\n- حمولة المستوى: 250 كجم.\n- سمك القايم: 1.0 مم.\n- سمك الرف: 0.8 مم.\n- وحدات متصلة أو منفصلة وبضاعة حاضرة.",
                ],
                'en' => [
                    'name' => 'Medium Duty Racking Unit - 4 Levels (2m W x 2m H x 60cm D) - 250kg/Level',
                    'description' => "Medium duty storage racking unit 4 levels for commercial and industrial storage.\nSpecifications:\n- Dimensions: 2m Width x 2m Height x 60cm Depth.\n- Levels: 4 Shelf Levels.\n- Capacity: 250 kg per level.\n- Upright: 1.0 mm thickness.\n- Shelf: 0.8 mm thickness.\n- Modular connected or standalone design.\n* In-stock.",
                ],
            ],
            [
                'sku' => 'MD-2.5X60-BLU',
                'price' => 8200,
                'category' => $catMedium,
                'weight' => 65.0,
                'image' => '/_fixed/book4.png',
                'is_best_seller' => false,
                'show_on_home' => false,
                'ar' => [
                    'name' => 'وحدة رفوف ميدي ديوتي ارتفاع 2.5م وعمق 60سم سمك 1.5مم (أزرق)',
                    'description' => "وحدة تخزين ميدي ديوتي بارتفاع خاص 2.5 متر وعمق 60 سم وقوائم سمك 1.5 مم باللون الأزرق المميز، حمولة 250 كجم للمستوى، بضاعة حاضرة.",
                ],
                'en' => [
                    'name' => 'Medium Duty Racking Unit H2.5m x D60cm (1.5mm Blue)',
                    'description' => 'Medium duty storage racking unit with 2.5m height, 60cm depth, and 1.5mm blue uprights. 250kg per level capacity, in-stock.',
                ],
            ],

            // ==========================================
            // 3. وحدات هيفي ديوتي (Heavy Duty Racking Units)
            // ==========================================
            [
                'sku' => 'HD-2X2X60-3L',
                'price' => 7850,
                'category' => $catHeavy,
                'weight' => 75.0,
                'image' => '/_fixed/book1.png',
                'is_best_seller' => true,
                'show_on_home' => true,
                'ar' => [
                    'name' => 'وحدة رفوف هيفي ديوتي 3 مستويات (2م عرض × 2م ارتفاع × 60سم عمق) - حمولة 500 كجم/مستوى',
                    'description' => "وحدات تخزين هيفي ديوتي للمستودعات الكبيرة والأحمال الثقيلة 500 كجم للمستوى الواحد.\nالمواصفات الفنية:\n- الأبعاد: 2 متر عرض × 2 متر ارتفاع × عمق 60 سم.\n- عدد المستويات: 3 مستويات بالأرفف.\n- حمولة المستوى: 500 كجم.\n- سمك القايم: 1.5 مم ثقيل.\n- سمك العارضة (Beam): 1.25 مم معصبة بـ 8 تنايات لمقاومة الانحناء.\n- بلاطات الرف: سمك 1.0 مم أو 0.8 مم مزودة بدعامات.\n- الوحدات مصممة لتكون منفصلة أو متصلة حسب خطة المستودع.\n* بضاعة حاضرة.",
                ],
                'en' => [
                    'name' => 'Heavy Duty Racking Unit - 3 Levels (2m W x 2m H x 60cm D) - 500kg/Level',
                    'description' => "Heavy duty warehouse racking unit for high capacity storage (500kg per level).\nSpecifications:\n- Dimensions: 2m Width x 2m Height x 60cm Depth.\n- Levels: 3 Levels.\n- Capacity: 500 kg per level.\n- Upright: 1.5 mm thickness heavy steel.\n- Beam: 1.25 mm with 8-fold reinforcement bends for anti-deflection.\n- Decking Panels: 1.0mm / 0.8mm with bottom support.\n- Modular standalone or continuous run.\n* In-stock.",
                ],
            ],
            [
                'sku' => 'HD-2X2X60-4L',
                'price' => 9900,
                'category' => $catHeavy,
                'weight' => 95.0,
                'image' => '/_fixed/book2.png',
                'is_best_seller' => true,
                'show_on_home' => true,
                'ar' => [
                    'name' => 'وحدة رفوف هيفي ديوتي 4 مستويات (2م عرض × 2م ارتفاع × 60سم عمق) - حمولة 500 كجم/مستوى',
                    'description' => "وحدات هيفي ديوتي 4 مستويات متكاملة بالأرفف للأوزان الثقيلة حتى 500 كجم للمستوى.\nالمواصفات الفنية:\n- الأبعاد: 2م عرض × 2م ارتفاع × 60سم عمق.\n- عدد المستويات: 4 مستويات بالأرفف.\n- حمولة المستوى: 500 كجم.\n- سمك القايم: 1.5 مم، العارضة 1.25 مم معصبة بـ 8 تنايات، البلاطات محملة بدعامات.\n* بضاعة حاضرة.",
                ],
                'en' => [
                    'name' => 'Heavy Duty Racking Unit - 4 Levels (2m W x 2m H x 60cm D) - 500kg/Level',
                    'description' => "Heavy duty 4-level warehouse storage racking with 500kg load capacity per level.\nSpecifications:\n- Dimensions: 2m W x 2m H x 60cm D.\n- Levels: 4 Complete Levels with decking.\n- Capacity: 500 kg per level.\n- 1.5mm Upright, 1.25mm 8-fold Beams, reinforced steel shelves.\n* In-stock.",
                ],
            ],
            [
                'sku' => 'HD-2.5X80-2MM',
                'price' => 10500,
                'category' => $catHeavy,
                'weight' => 110.0,
                'image' => '/_fixed/book3.png',
                'is_best_seller' => false,
                'show_on_home' => false,
                'ar' => [
                    'name' => 'وحدة رفوف هيفي ديوتي ارتفاع 2.5م وعمق 80سم سمك 2مم (حمولة 500 كجم/مستوى)',
                    'description' => "وحدة تخزين هيفي ديوتي عملاقة بارتفاع 2.5 متر وعمق 80 سم وقوائم سمك 2 مم للمعدات والمخازن الصناعية الكبرى، حمولة المستوى 500 كجم، بضاعة حاضرة.",
                ],
                'en' => [
                    'name' => 'Heavy Duty Racking Unit - H2.5m x D80cm (2mm Upright)',
                    'description' => 'Extra-deep heavy duty warehouse racking unit: 2.5m height, 80cm depth, 2.0mm thick steel uprights, 500kg per level capacity.',
                ],
            ],

            // ==========================================
            // 4. دواليب ولوكرات معدنية وشانونات
            // ==========================================
            [
                'sku' => 'CAB-DOC-2D',
                'price' => 5000,
                'category' => $catCabinets,
                'weight' => 38.0,
                'image' => '/_fixed/book4.png',
                'is_best_seller' => true,
                'show_on_home' => true,
                'ar' => [
                    'name' => 'دولاب مستندات معدني 2 ضلفة و3 رف متحرك (180 ارتفاع × 90 عرض × 40 عمق سم)',
                    'description' => "دولاب حفظ مستندات وأرشيف مكتبي معدني مصفح 2 ضلفة.\nالمواصفات الفنية:\n- الأبعاد: 180 سم ارتفاع × 90 سم عرض × 40 سم عمق.\n- عدد الأرفف: 3 أرفف داخلية قابلة للتحريك وتعديل الارتفاع.\n- الأبواب: 2 ضلفة بمقبض مدمج وكالون مركزي بمفتاحين.\n- الدهان: إلكتروستاتيك مقاوم للصدأ والخدش ومقاوم للحريق.\n* بضاعة حاضرة.",
                ],
                'en' => [
                    'name' => '2-Door Metal Document Cabinet with 3 Adjustable Shelves (180H x 90W x 40D cm)',
                    'description' => "Steel office document and file archive cabinet with 2 doors.\nSpecifications:\n- Dimensions: 180cm Height x 90cm Width x 40cm Depth.\n- Interior: 3 adjustable metal shelves (4 compartments).\n- Lock: Central security lock with 2 keys.\n- Finish: Scratch & rust resistant electrostatic powder coating.\n* In-stock.",
                ],
            ],
            [
                'sku' => 'LCK-6D-HVY',
                'price' => 5300,
                'category' => $catCabinets,
                'weight' => 45.0,
                'image' => '/_fixed/book1.png',
                'is_best_seller' => true,
                'show_on_home' => true,
                'ar' => [
                    'name' => 'دولاب لوكر معدني 6 ضلفة محمل (180 ارتفاع × 90 عرض × 40 عمق سم - سمك 0.8 مم)',
                    'description' => "دولاب لوكر عمال وموظفين 6 ضلف معدني محمل عالي الجودة.\nالمواصفات الفنية:\n- الأبعاد: 180 سم ارتفاع × 90 سم عرض × 40 سم عمق.\n- السمك: صاج 0.8 مم محمل.\n- التجهيزات: إكسسوار بلاستيك عالي الجودة + كالون خاص ومفتاحين لكل ضلفة + رف داخلي في كل ضلفة + فتحات تهوية.\n- اللون: أزرق ورمادي.\n* بضاعة حاضرة.",
                ],
                'en' => [
                    'name' => '6-Door Heavy-Duty Metal Locker (180H x 90W x 40D cm - 0.8mm Blue & Grey)',
                    'description' => "Heavy-duty 6-compartment steel employee locker.\nSpecifications:\n- Dimensions: 180cm H x 90cm W x 40cm D.\n- Steel Gauge: 0.8 mm reinforced steel.\n- Accessories: Plastic hardware, individual lock & keys for each door, internal shelf per compartment, ventilation slots.\n- Colors: Blue & Grey.\n* In-stock.",
                ],
            ],
            [
                'sku' => 'LCK-4D-HVY',
                'price' => 4900,
                'category' => $catCabinets,
                'weight' => 36.0,
                'image' => '/_fixed/book2.png',
                'is_best_seller' => false,
                'show_on_home' => true,
                'ar' => [
                    'name' => 'دولاب لوكر معدني 4 ضلفة محمل (180 ارتفاع × 60 عرض × 40 عمق سم - سمك 0.8 مم - بيج)',
                    'description' => "دولاب لوكر معدني 4 ضلفة محمل للموظفين والأندية والمصانع.\nالمواصفات:\n- الأبعاد: 180 سم ارتفاع × 60 سم عرض × 40 سم عمق.\n- السمك: 0.8 مم محمل.\n- التجهيزات: إكسسوار بلاستيك، كالون لكل ضلفة، ورف داخلي في كل ضلفة.\n- اللون: بيج أنيق.\n* بضاعة حاضرة.",
                ],
                'en' => [
                    'name' => '4-Door Heavy-Duty Metal Locker (180H x 60W x 40D cm - 0.8mm Beige)',
                    'description' => "Heavy-duty 4-door steel locker for staff, gyms, and commercial use.\nSpecifications:\n- Dimensions: 180cm H x 60cm W x 40cm D.\n- Steel: 0.8 mm.\n- Features: Individual locks, plastic handles, internal shelf in each compartment.\n- Color: Elegant Beige.\n* In-stock.",
                ],
            ],
            [
                'sku' => 'LCK-2D-HVY',
                'price' => 3650,
                'category' => $catCabinets,
                'weight' => 26.0,
                'image' => '/_fixed/book3.png',
                'is_best_seller' => false,
                'show_on_home' => true,
                'ar' => [
                    'name' => 'دولاب لوكر معدني 2 ضلفة محمل (180 ارتفاع × 45 عرض × 40 عمق سم - سمك 0.8 مم)',
                    'description' => "دولاب لوكر معدني رأسي 2 ضلفة محمل للمساحات المحدودة.\nالمواصفات:\n- الأبعاد: 180 سم ارتفاع × 45 سم عرض × 40 سم عمق.\n- السمك: 0.8 مم محمل.\n- التجهيزات: إكسسوار بلاستيك، كالون لكل ضلفة، ورف داخلي في كل ضلفة.\n- اللون: أزرق ورمادي.\n* بضاعة حاضرة.",
                ],
                'en' => [
                    'name' => '2-Door Heavy-Duty Metal Locker (180H x 45W x 40D cm - 0.8mm Blue & Grey)',
                    'description' => "Compact 2-door heavy-duty steel locker.\nSpecifications:\n- Dimensions: 180cm H x 45cm W x 40cm D.\n- Steel: 0.8 mm.\n- Features: Independent lock for each door, internal shelf, ventilation louvers.\n- Color: Blue & Grey.\n* In-stock.",
                ],
            ],
            [
                'sku' => 'LCK-6D-COM',
                'price' => 3000,
                'category' => $catCabinets,
                'weight' => 30.0,
                'image' => '/_fixed/book4.png',
                'is_best_seller' => false,
                'show_on_home' => false,
                'ar' => [
                    'name' => 'لوكر معدني تجاري 6 ضلفة (180 ارتفاع × 90 عرض × 40 عمق سم - سمك 0.5 مم)',
                    'description' => 'دولاب لوكر تجاري اقتصادي 6 ضلفة مقاس 180 سم ارتفاع × 90 سم عرض × 40 سم عمق، سمك صاج 0.5 مم بكالون منفصل لكل ضلفة، بضاعة حاضرة.',
                ],
                'en' => [
                    'name' => '6-Door Commercial Metal Locker (180H x 90W x 40D cm - 0.5mm)',
                    'description' => 'Economic commercial 6-door steel locker 180x90x40cm, 0.5mm thickness with individual locks.',
                ],
            ],
            [
                'sku' => 'SHN-WD-MET-4D',
                'price' => 5650,
                'category' => $catCabinets,
                'weight' => 42.0,
                'image' => '/_fixed/book1.png',
                'is_best_seller' => true,
                'show_on_home' => true,
                'ar' => [
                    'name' => 'شانون خشب × معدن 4 درج محمل موبيكا (120 ارتفاع × 40 عرض × 50 عمق سم)',
                    'description' => "شانون حفظ ملفات وأوراق 4 درج فاخر خشب مع معدن (ستايل موبيكا المحمل).\nالمواصفات الفنية:\n- الأبعاد: 120 سم ارتفاع × 40 سم عرض × 50 سم عمق.\n- الأدراج: 4 أدراج مجهزة لحفظ وتصنيف الملفات المعلقة.\n- مجاري الأدراج: مجاري تلسكوبية محملة وسلسة الفتح.\n- القفل: كالون مركزي يقفل جميع الأدراج.\n* بضاعة حاضرة.",
                ],
                'en' => [
                    'name' => '4-Drawer Wood & Metal Filing Cabinet Heavy-Duty Mobica Style (120H x 40W x 50D cm)',
                    'description' => "Premium 4-drawer wood & metal heavy-duty filing cabinet (Mobica design).\nSpecifications:\n- Dimensions: 120cm H x 40cm W x 50cm D.\n- Drawers: 4 spacious drawers for hanging files and documents.\n- Slides: Heavy-duty smooth telescopic ball-bearing drawer slides.\n- Lock: Central locking system with master keys.\n* In-stock.",
                ],
            ],
            [
                'sku' => 'SHN-MET-4D',
                'price' => 4400,
                'category' => $catCabinets,
                'weight' => 32.0,
                'image' => '/_fixed/book2.png',
                'is_best_seller' => false,
                'show_on_home' => true,
                'ar' => [
                    'name' => 'شانون معدني عادي 4 درج بمجرى عادية (120 ارتفاع × 40 عرض × 50 عمق سم)',
                    'description' => 'شانون حفظ ملفات معدني 4 أدراج بمجرى عادية، مقاس 120 سم ارتفاع × 40 سم عرض × 50 سم عمق بكالون قفل للأدراج، بضاعة حاضرة.',
                ],
                'en' => [
                    'name' => '4-Drawer Standard Metal Filing Cabinet (120H x 40W x 50D cm)',
                    'description' => 'Standard steel 4-drawer filing cabinet (120H x 40W x 50D cm) with central lock and standard drawer slides.',
                ],
            ],

            // ==========================================
            // 5. أرفف وقوائم واكسسوارات منفصلة
            // ==========================================
            [
                'sku' => 'PRT-SH-1X30-BRK',
                'price' => 130,
                'category' => $catComponents,
                'weight' => 1.8,
                'image' => '/_fixed/book3.png',
                'is_best_seller' => false,
                'show_on_home' => false,
                'ar' => [
                    'name' => 'رف معدني عرض 1م × عمق 30سم بالكوابيل',
                    'description' => 'رف صاج معدني عرض 1 متر × عمق 30 سم شامل زوج كوابيل تثبيت معدنية، مدهون إلكتروستاتيك، بضاعة حاضرة.',
                ],
                'en' => [
                    'name' => 'Metal Shelf 1m x 30cm with Brackets',
                    'description' => 'Steel shelf panel 1m width x 30cm depth complete with mounting brackets, in-stock.',
                ],
            ],
            [
                'sku' => 'PRT-UP-2M',
                'price' => 120,
                'category' => $catComponents,
                'weight' => 1.5,
                'image' => '/_fixed/book4.png',
                'is_best_seller' => false,
                'show_on_home' => false,
                'ar' => [
                    'name' => 'قايم معدني مثقب ارتفاع 2 متر (زاوية حديد)',
                    'description' => 'قايم زاوية حديد مثقب ارتفاع 2 متر لتجميع وتثبيت وحدات الأرفف المعدنية، مدهون إلكتروستاتيك، بضاعة حاضرة.',
                ],
                'en' => [
                    'name' => 'Slotted Angle Upright Post 2m Height',
                    'description' => 'Slotted angle steel upright post 2m height for shelving unit assembly, electrostatic coated.',
                ],
            ],
            [
                'sku' => 'PRT-GRID-1M',
                'price' => 280,
                'category' => $catComponents,
                'weight' => 2.2,
                'image' => '/_fixed/book1.png',
                'is_best_seller' => false,
                'show_on_home' => false,
                'ar' => [
                    'name' => 'رف شبك معدني سلك عرض 1 متر',
                    'description' => 'رف شبكي معدني من السلك المجلفن/المدهون عرض 1 متر للتهوية والتخزين، بضاعة حاضرة.',
                ],
                'en' => [
                    'name' => 'Wire Grid Metal Shelf 1m Width',
                    'description' => 'Wire mesh steel shelf 1m width for ventilated storage and retail display.',
                ],
            ],
            [
                'sku' => 'PRT-SH-1X40-2SUP',
                'price' => 180,
                'category' => $catComponents,
                'weight' => 2.6,
                'image' => '/_fixed/book2.png',
                'is_best_seller' => false,
                'show_on_home' => false,
                'ar' => [
                    'name' => 'رف معدني عرض 1م × عمق 40سم بـ 2 دعامة تقوية',
                    'description' => 'رف صاج معدني محمل عرض 1 متر × عمق 40 سم مزود بـ 2 دعامة تقوية سفلية لزيادة قوة التحمل، بضاعة حاضرة.',
                ],
                'en' => [
                    'name' => 'Reinforced Metal Shelf 1m x 40cm with 2 Supports',
                    'description' => 'Reinforced steel shelf 1m width x 40cm depth with 2 underside reinforcement supports for heavy loading.',
                ],
            ],
            [
                'sku' => 'PRT-UP-2.5M',
                'price' => 175,
                'category' => $catComponents,
                'weight' => 2.0,
                'image' => '/_fixed/book3.png',
                'is_best_seller' => false,
                'show_on_home' => false,
                'ar' => [
                    'name' => 'قايم معدني مثقب ارتفاع 2.5 متر (زاوية حديد)',
                    'description' => 'قايم زاوية حديد مثقب ارتفاع 2.5 متر للمخازن والارتفاعات العالية، مدهون إلكتروستاتيك، بضاعة حاضرة.',
                ],
                'en' => [
                    'name' => 'Slotted Angle Upright Post 2.5m Height',
                    'description' => 'Slotted angle steel upright post 2.5m height for high ceiling warehouse shelving.',
                ],
            ],
        ];

        // Fetch options for attaching
        $allOptions = Option::with('values.translations')->get();

        foreach ($productsData as $data) {
            $product = Product::create([
                'price' => $data['price'],
                'status' => true,
                'vendor_id' => null,
                'shipping_rule_id' => $shippingRule ? $shippingRule->id : null,
                'product_brand_id' => $brand ? $brand->id : null,
                'sku' => $data['sku'],
                'image' => $data['image'],
                'special_price' => null,
                'special_price_start' => null,
                'special_price_end' => null,
                'quantity' => 100,
                'max_order_qty' => 50,
                'ignore_quantity' => true,
                'is_best_seller' => $data['is_best_seller'],
                'show_on_home' => $data['show_on_home'] ?? true,
                'weight' => $data['weight'],
                'viewed' => rand(50, 600),
            ]);

            // Create Translations
            ProductTranslation::create([
                'product_id' => $product->id,
                'locale' => 'ar',
                'name' => $data['ar']['name'],
                'description' => $data['ar']['description'],
                'slug' => Str::slug($data['ar']['name']) . '-' . $product->id,
                'meta_title' => $data['ar']['name'] . ' | قايم ورف',
                'meta_description' => Str::limit($data['ar']['description'], 160),
                'meta_keywords' => 'قايم ورف, ارفف تخزين, ارفف مخازن, استاندات حديد, لوكرات, شانونات, دواليب مستندات, هيفي ديوتي, ميدي ديوتي',
            ]);

            ProductTranslation::create([
                'product_id' => $product->id,
                'locale' => 'en',
                'name' => $data['en']['name'],
                'description' => $data['en']['description'],
                'slug' => Str::slug($data['en']['name']) . '-' . $product->id,
                'meta_title' => $data['en']['name'] . ' | Qayem W Raf',
                'meta_description' => Str::limit($data['en']['description'], 160),
                'meta_keywords' => 'shelving, racking, storage units, metal lockers, document cabinets, heavy duty, medium duty',
            ]);

            // Attach Category
            if (!empty($data['category'])) {
                $product->categories()->attach($data['category']->id);
            }

            // Create placeholder images
            for ($k = 0; $k < 3; $k++) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $data['image'],
                    'sort_order' => $k,
                ]);
            }
        }
    }
}
