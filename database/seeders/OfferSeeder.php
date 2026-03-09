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
                'ar' => ['name' => 'القرآن الكريم'],
                'en' => ['name' => 'The Holy Quran'],
                'image' => '/_fixed/offers.jpg',
            ],
            [
                'ar' => ['name' => 'كتب إسلامية'],
                'en' => ['name' => 'Islamic Books'],
                'image' => '/_fixed/offers.jpg',
            ],
            [
                'ar' => ['name' => 'الأدب والروايات'],
                'en' => ['name' => 'Literature & Novels'],
                'image' => '/_fixed/offers.jpg',
            ],
            [
                'ar' => ['name' => 'تطوير الذات'],
                'en' => ['name' => 'Self Development'],
                'image' => '/_fixed/offers.jpg',
            ],
            [
                'ar' => ['name' => 'التاريخ الإسلامي'],
                'en' => ['name' => 'Islamic History'],
                'image' => '/_fixed/offers.jpg',
            ],
        ];

        foreach ($offers as $index => $data) {
            $enSlug = Str::slug($data['en']['name'] . '-en');
            $existingTranslation = OfferTranslation::where('slug', $enSlug)->first();
            $offer = $existingTranslation ? Offer::find($existingTranslation->offer_id) : null;

            if (!$offer) {
                $offer = Offer::create([
                    'image' => $data['image'],
                    'is_active' => true,
                    'sort_order' => $index,
                ]);
            } else {
                $offer->update([
                    'image' => $data['image'],
                    'is_active' => true,
                    'sort_order' => $index,
                ]);
            }

            foreach (['ar', 'en'] as $locale) {
                OfferTranslation::updateOrCreate([
                    'offer_id' => $offer->id,
                    'locale' => $locale,
                ], [
                    'name' => $data[$locale]['name'],
                    'slug' => Str::slug($data['en']['name'] . '-' . $locale),
                ]);
            }
        }
    }
}
