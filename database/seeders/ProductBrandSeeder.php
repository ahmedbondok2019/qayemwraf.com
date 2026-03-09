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
                'ar' => 'دار السلام',
                'en' => 'Dar Al-Salam',
                'image' => '/_fixed/brands.png',
            ],
            [
                'ar' => 'دار ابن حزم',
                'en' => 'Dar Ibn Hazm',
                'image' => '/_fixed/brands.png',
            ],
            [
                'ar' => 'مكتبة جرير',
                'en' => 'Jarir Bookstore',
                'image' => '/_fixed/brands.png',
            ],
            [
                'ar' => 'دار المعرفة',
                'en' => 'Dar Al-Maarefa',
                'image' => '/_fixed/brands.png',
            ],
            [
                'ar' => 'دار الشروق',
                'en' => 'Dar Al-Shorouk',
                'image' => '/_fixed/brands.png',
            ],
            [
                'ar' => 'عصير الكتب',
                'en' => 'Aseer Al-Kotob',
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
