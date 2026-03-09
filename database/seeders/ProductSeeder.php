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
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Check if Faker exists (it's a dev dependency)
        if (!class_exists(\Faker\Factory::class)) {
            $this->command->warn('Faker library not found. Skipping ProductSeeder. Run "composer install" (with dev dependencies) to enable.');
            return;
        }

        $faker = \Faker\Factory::create('ar_SA'); // Arabic faker
        $fakerEn = \Faker\Factory::create('en_US');

        // Get dependencies
        $categories = Category::all();
        $brands = ProductBrand::all();
        $shippingRule = ShippingRule::first();
        $options = Option::with('values')->get();

        // Islamic Book Titles Generator Lists
        $prefixes = ['شرح', 'تفسير', 'متن', 'حاشية', 'مختصر', 'تهذيب', 'صحيح', 'مسند', 'تاريخ'];
        $topics = ['البخاري', 'مسلم', 'الفقه', 'العقيدة', 'السيرة النبوية', 'القرآن', 'التجويد', 'الأذكار', 'الحديث', 'الميراث'];
        $subs = ['الميسر', 'الشامل', 'الوافي', 'الكبير', 'الصغير', 'الوجيز', 'الجامع'];

        $enPrefixes = ['Explanation of', 'Interpretation of', 'Text of', 'Summary of', 'History of', 'Guide to'];
        $enTopics = ['Al-Bukhari', 'Muslim', 'Fiqh', 'Aqidah', 'Prophet Biography', 'Quran', 'Tajweed', 'Hadith', 'Inheritance'];

        // Images placeholder (assuming some exist or using placeholders)
        // In a real scenario, we might have actual images. I'll use placeholders.
        $images = [
            '/_fixed/book1.png',
            '/_fixed/book2.png',
            '/_fixed/book3.png',
            '/_fixed/book4.png',
            '/_fixed/quran1.png',
        ];

        for ($i = 0; $i < 100; $i++) {
            // Generate Name
            $arName = $faker->randomElement($prefixes) . ' ' . $faker->randomElement($topics) . ' ' . $faker->randomElement($subs);
            $enName = $fakerEn->randomElement($enPrefixes) . ' ' . $fakerEn->randomElement($enTopics);

            // Generate Price
            $price = $faker->numberBetween(50, 500);
            $hasSpecialPrice = $faker->boolean(30); // 30% chance
            $specialPrice = $hasSpecialPrice ? $price * 0.8 : null;

            // Create Product
            $product = Product::create([
                'price' => $price,
                'status' => true,
                'vendor_id' => null, // or random vendor if implemented
                'shipping_rule_id' => $shippingRule ? $shippingRule->id : null,
                'product_brand_id' => $brands->isNotEmpty() ? $brands->random()->id : null,
                'sku' => strtoupper(Str::random(8)),
                'image' => $faker->randomElement($images),
                'special_price' => $specialPrice,
                'special_price_start' => $hasSpecialPrice ? now()->subDays(1) : null,
                'special_price_end' => $hasSpecialPrice ? now()->addDays(15) : null,
                'quantity' => $faker->numberBetween(10, 200),
                'max_order_qty' => 10,
                'ignore_quantity' => false,
                'is_best_seller' => $faker->boolean(10),
                'best_seller_start' => $faker->boolean(10) ? now() : null,
                'weight' => $faker->randomFloat(2, 0.5, 2.0),
                'viewed' => $faker->numberBetween(0, 5000),
            ]);

            // Create Translations
            ProductTranslation::create([
                'product_id' => $product->id,
                'locale' => 'ar',
                'name' => $arName,
                'description' => $faker->paragraph(3) . ' ' . $arName,
                'slug' => Str::slug($arName) . '-' . $product->id,
                'meta_title' => $arName,
                'meta_description' => $faker->sentence,
            ]);

            ProductTranslation::create([
                'product_id' => $product->id,
                'locale' => 'en',
                'name' => $enName,
                'description' => $fakerEn->paragraph(3) . ' ' . $enName,
                'slug' => Str::slug($enName) . '-' . $product->id,
                'meta_title' => $enName,
                'meta_description' => $fakerEn->sentence,
            ]);

            // Attach Categories
            if ($categories->isNotEmpty()) {
                $randomCategories = $categories->random(rand(1, 3))->pluck('id');
                $product->categories()->attach($randomCategories);
            }

            // Attach Options
            if ($options->isNotEmpty() && $faker->boolean(80)) {
                $randomOptions = $options->random(rand(2, 4));
                foreach ($randomOptions as $opt) {
                    $productOption = ProductOption::create([
                        'product_id' => $product->id,
                        'option_id' => $opt->id,
                        'required' => $faker->boolean(30),
                    ]);

                    $randomValues = $opt->values->random(rand(1, min(3, $opt->values->count())));
                    foreach ($randomValues as $val) {
                        ProductOptionValue::create([
                            'product_option_id' => $productOption->id,
                            'option_value_id' => $val->id,
                            'quantity' => $faker->numberBetween(5, 50),
                            'subtract_stock' => true,
                            'price_increment' => true,
                            'price' => $faker->randomElement([0, 0, 0, 10, 25, 50]),
                        ]);
                    }
                }
            }
        }
    }
}
