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
        $setting = Setting::first();

        if (!$setting) {
            Setting::create([
                'app_name' => 'Mushaf Home',
                'app_meta_title' => 'Mushaf Home - Default Title',
                'app_meta_desc' => 'Default Meta Description for Mushaf Home application.',
                'address' => 'Cairo, Egypt',
                'phone' => '01000000000',
                'contact_email' => 'info@mushafhome.com',
                'facebook' => 'https://facebook.com',
                'instagram' => 'https://instagram.com',
                'twitter' => 'https://twitter.com',
                'youtube' => 'https://youtube.com',
                'whatsapp' => '01000000000',
                'linkedin' => 'https://linkedin.com',
                'dollar_rate' => 50.00,
                'saudi_riyal_rate' => 13.00,
                'egypt_rate' => 1.00,
                'base_currency' => 'EGP',
                'logo' => '/_fixed/logo.png',
                'logo_dark' => '/_fixed/logo.png',
                'fav_icon' => '/_fixed/logo.png',
            ]);
        }
    }
}
