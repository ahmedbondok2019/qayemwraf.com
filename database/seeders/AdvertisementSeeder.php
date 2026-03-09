<?php

namespace Database\Seeders;

use App\Models\Advertisement;
use App\Models\AdvertisementTranslation;
use App\Models\Category;
use Illuminate\Database\Seeder;

class AdvertisementSeeder extends Seeder
{
    // 
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 
        // 
        // 
        // 1. Home Advertisement
        $homeAd = Advertisement::create([
            'location' => 'home',
            'start_at' => now(),
            'end_at' => now()->addDays(30),
            'is_active' => true,
        ]);
        
        AdvertisementTranslation::create([
            'advertisement_id' => $homeAd->id,
            'locale' => 'en',
            'image' => '/_fixed/ads.webp', // Placeholder path
            'link' => 'https://example.com/sale',
        ]);
        
         AdvertisementTranslation::create([
            'advertisement_id' => $homeAd->id,
            'locale' => 'ar',
            'image' => '/_fixed/ads.webp', // Placeholder path
            'link' => 'https://example.com/sale',
        ]);


        // 2. Category Advertisement
        $category = Category::first();
        if ($category) {
            $catAd = Advertisement::create([
                'location' => 'category',
                'start_at' => now(),
                'end_at' => now()->addDays(15),
                'is_active' => true,
            ]);
            // Note: category_id removed from schema as per user request, so not saving it here.
            // If the user meant "don't use category_id constraint" but still link it, we'd need another way.
            // But obeying request to remove category_id implicitly means generic category ads or relying on something else?
            // Wait, if no category_id, how to link to category? Maybe user implies 'location'='category' is enough?
            // Or maybe I should assume no category linkage for now based on "use two tables ... no category_id". 
            // I'll proceed without setting category_id.

            AdvertisementTranslation::create([
                'advertisement_id' => $catAd->id,
                'locale' => 'en',
                'image' => '/_fixed/ads.webp', // Placeholder path
                'link' => '#',
            ]);

             AdvertisementTranslation::create([
                'advertisement_id' => $catAd->id,
                'locale' => 'ar',
                'image' => '/_fixed/ads.webp', // Placeholder path
                'link' => '#',
            ]);
        }


        // 3. Popup Advertisement
        $popupAd = Advertisement::create([
            'location' => 'popup',
            'start_at' => now(),
            'end_at' => now()->addDays(7),
            'is_active' => true,
        ]);

        AdvertisementTranslation::create([
            'advertisement_id' => $popupAd->id,
            'locale' => 'en',
            'image' => '/_fixed/ads.webp', // Placeholder path
            'link' => '#subscribe',
        ]);
        
        AdvertisementTranslation::create([
            'advertisement_id' => $popupAd->id,
            'locale' => 'ar',
            'image' => '/_fixed/ads.webp', // Placeholder path
            'link' => '#subscribe',
        ]);
    }
}
