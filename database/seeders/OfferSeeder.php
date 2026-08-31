<?php

namespace Database\Seeders;

use App\Models\Offer;
use App\Models\OfferTranslation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $offers = [
            [
                'ar' => ['name' => 'وحدات أرفف تخزين خفيفة ومتوسطة'],
                'en' => ['name' => 'Standard & Light Shelving Units'],
                'image' => '/_fixed/offers.jpg',
            ],
            [
                'ar' => ['name' => 'وحدات تخزين ميدي ديوتي (لايت ميدي)'],
                'en' => ['name' => 'Medium Duty Racking Units'],
                'image' => '/_fixed/offers.jpg',
            ],
            [
                'ar' => ['name' => 'وحدات تخزين هيفي ديوتي للمخازن'],
                'en' => ['name' => 'Heavy Duty Warehouse Racking'],
                'image' => '/_fixed/offers.jpg',
            ],
            [
                'ar' => ['name' => 'دواليب ولوكرات معدنية وشانونات'],
                'en' => ['name' => 'Metal Lockers & Cabinets'],
                'image' => '/_fixed/offers.jpg',
            ],
        ];

        foreach ($offers as $index => $data) {
            $offer = Offer::create([
                'image' => $data['image'],
                'is_active' => true,
                'sort_order' => $index,
            ]);

            foreach (['ar', 'en'] as $locale) {
                OfferTranslation::create([
                    'offer_id' => $offer->id,
                    'locale' => $locale,
                    'name' => $data[$locale]['name'],
                    'slug' => Str::slug($data['en']['name'] . '-' . $locale . '-' . $offer->id),
                ]);
            }
        }
    }
}
