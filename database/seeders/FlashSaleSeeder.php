<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FlashSale;
use App\Models\FlashSaleTranslation;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FlashSaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define some flash sales
        $sales = [
            [
                'start_at' => Carbon::now()->subDays(1),
                'end_at' => Carbon::now()->addDays(5),
                'is_active' => true,
                'image' => '/_fixed/flash1.jpg',
                'translations' => [
                    'en' => 'Ramadan Flash Sale',
                    'ar' => 'عروض فلاش رمضان',
                ],
            ],
            [
                'start_at' => Carbon::now()->addDays(10),
                'end_at' => Carbon::now()->addDays(15),
                'is_active' => true,
                'image' => '/_fixed/flash2.jpg',
                'translations' => [
                    'en' => 'Eid Al-Fitr Deals',
                    'ar' => 'عروض عيد الفطر',
                ],
            ],
             [
                'start_at' => Carbon::now()->subDays(20),
                'end_at' => Carbon::now()->subDays(15),
                'is_active' => false, // Expired
                'image' => 'website/images/flash_sales/old.jpg',
                'translations' => [
                    'en' => 'Previous Season Sale',
                    'ar' => 'تخفيضات الموسم السابق',
                ],
            ],
        ];

        // Get some random products
        $allProducts = Product::inRandomOrder()->limit(30)->get();

        foreach ($sales as $saleData) {
            $flashSale = FlashSale::create([
                'start_at' => $saleData['start_at'],
                'end_at' => $saleData['end_at'],
                'is_active' => $saleData['is_active'],
                'image' => $saleData['image'],
            ]);

            // Translations
            foreach ($saleData['translations'] as $locale => $name) {
                FlashSaleTranslation::create([
                    'flash_sale_id' => $flashSale->id,
                    'locale' => $locale,
                    'name' => $name,
                ]);
            }

            // Associate random products with prices
            if ($allProducts->count() > 0) {
                $randomProducts = $allProducts->random(min(5, $allProducts->count()));
                foreach ($randomProducts as $product) {
                    DB::table('flash_sale_products')->insert([
                        'flash_sale_id' => $flashSale->id,
                        'product_id' => $product->id,
                        'price' => $product->price > 0 ? $product->price * 0.8 : 50, // 20% off or dummy price
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
