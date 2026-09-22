<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defaults = Setting::defaultAboutSection();

        Setting::updateOrCreate(
            ['id' => 1],
            [
                'app_name' => [
                    'ar' => 'قائم ورف للمشغولات المعدنية وحلول التخزين',
                    'en' => 'Qayem & Raf for Metal Works & Storage Solutions',
                ],
                'app_meta_title' => [
                    'ar' => 'قائم ورف للمشغولات المعدنية وحلول التخزين | Qayem & Raf',
                    'en' => 'Qayem & Raf | Metal Works & Warehouse Storage Solutions',
                ],
                'app_meta_desc' => [
                    'ar' => 'شركة قائم ورف للمشغولات المعدنية وحلول التخزين - متخصصون في تصميم وتصنيع وتوريد كافة أنظمة الرفوف المعدنية ووحدات التخزين وتجهيز المستودعات والمخازن بأعلى معايير الجودة والمتانة.',
                    'en' => 'Qayem & Raf for Metal Works & Storage Solutions - Specialists in designing, manufacturing, and supplying industrial racking systems, metal shelving, and comprehensive warehouse solutions.',
                ],
                'address' => [
                    'ar' => '35 عمارات التوفيقية، شرق مدينة نصر النادي الأهلي، القاهرة',
                    'en' => 'tawfikiya bldgs., East Nasr City Al Ahly Club, Cairo, Egypt 35',
                ],
                'factory_address' => [
                    'ar' => 'المنطقة الصناعية - 6 أكتوبر - الجيزة',
                    'en' => 'Industrial Zone, 6th of October City, Giza, Egypt',
                ],
                'phone' => '01154813836',
                'whatsapp' => '01154813836',
                'contact_email' => 'ahmed.kamel@qayemwraf.com',
                'facebook' => 'https://www.facebook.com/profile.php?id=61564663319105',
                'instagram' => 'https://www.instagram.com/qayemwraf/',
                'twitter' => 'https://twitter.com',
                'youtube' => 'https://youtube.com',
                'linkedin' => 'https://linkedin.com',
                'dollar_rate' => 50.00,
                'saudi_riyal_rate' => 13.00,
                'egypt_rate' => 1.00,
                'base_currency' => 'EGP',
                'about_tag' => $defaults['tag'],
                'about_title' => $defaults['title'],
                'about_highlight_text' => $defaults['highlight_text'],
                'about_description' => $defaults['description'],
                'about_stats' => $defaults['stats'],
                'about_features' => $defaults['features'],
                'about_image_1_badge_title' => $defaults['image_1_badge_title'],
                'about_image_1_badge_subtitle' => $defaults['image_1_badge_subtitle'],
                'about_image_2_badge' => $defaults['image_2_badge'],
                'about_experience_years' => $defaults['experience_years'],
                'about_experience_title' => $defaults['experience_title'],
                'about_experience_subtitle' => $defaults['experience_subtitle'],
            ]
        );
    }
}
