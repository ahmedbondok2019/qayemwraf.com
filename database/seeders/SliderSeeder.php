<?php

namespace Database\Seeders;

use App\Models\Slider;
use App\Models\SliderTranslation;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sliders = [
            [
                'ar' => [
                    'title' => 'Welcome to qayemwraf',
                    'subtitle' => 'Your Favorite Store',
                    'button_text' => 'تسوق الآن',
                ],
                'en' => [
                    'title' => 'Welcome to qayemwraf',
                    'subtitle' => 'Your Favorite Store',
                    'button_text' => 'Shop Now',
                ],
                'image' => '/_fixed/sliders.jpg',
                'link' => '/ar/products',
            ],
            [
                'ar' => [
                    'title' => 'جديد المصاحف',
                    'subtitle' => 'تشكيلة متنوعة من المصاحف الملونة والمفسرة',
                    'button_text' => 'عرض المزيد',
                ],
                'en' => [
                    'title' => 'New Quran Collection',
                    'subtitle' => 'A variety of colored and interpreted Qurans',
                    'button_text' => 'View More',
                ],
                'image' => '/_fixed/sliders.jpg',
                'link' => '/ar/products?category=the-holy-quran-ar',
            ],
        ];

        foreach ($sliders as $index => $data) {
            $slider = Slider::create([
                'image' => $data['image'],
                'link' => $data['link'],
                'is_active' => true,
                'sort_order' => $index,
            ]);

            foreach (['ar', 'en'] as $locale) {
                SliderTranslation::create([
                    'slider_id' => $slider->id,
                    'locale' => $locale,
                    'title' => $data[$locale]['title'],
                    'subtitle' => $data[$locale]['subtitle'],
                    'button_text' => $data[$locale]['button_text'],
                ]);
            }
        }
    }
}
