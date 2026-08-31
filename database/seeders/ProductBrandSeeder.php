<?php

namespace Database\Seeders;

use App\Models\ProductBrand;
use App\Models\ProductBrandTranslation;
use Illuminate\Database\Seeder;

class ProductBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            [
                'ar' => 'تصنيع محلي',
                'en' => 'Local Made',
                'image' => '/_fixed/brands.png',
            ],
            [
                'ar' => 'قايم ورف',
                'en' => 'Qayem W Raf',
                'image' => '/_fixed/brands.png',
            ],
        ];

        foreach ($brands as $index => $data) {
            $brand = ProductBrand::create([
                'image' => $data['image'],
                'is_active' => true,
                'sort_order' => $index,
            ]);

            foreach (['ar', 'en'] as $locale) {
                ProductBrandTranslation::create([
                    'product_brand_id' => $brand->id,
                    'locale' => $locale,
                    'title' => $data[$locale],
                ]);
            }
        }
    }
}
