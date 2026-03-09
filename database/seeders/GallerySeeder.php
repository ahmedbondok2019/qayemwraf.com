<?php

namespace Database\Seeders;

use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\GalleryTranslation;
use App\Models\GalleryVideo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class GallerySeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 50; $i++) {
            $id = Gallery::create([
                'lang_id' => app()->getLocale(),
                'view_index' => mt_rand(100, 999),
                'status' => 1,
            ]);

            $trans = GalleryTranslation::create([
                'gallery_name' => Str::random('10'),
                'gallery_location' => Str::random('100'),
                'gallery_date' => Carbon::now(),
                'gallery_id' => $id->id,
                'views' => mt_rand(100, 999),
                'lang_id' => app()->getLocale(),
            ]);

            GalleryImage::create([
                'image' => 'test.jpg',
                'translation_id' => $trans->id,
                'gallery_id' => $id->id,
                'lang_id' => app()->getLocale(),
            ]);

            GalleryVideo::create([
                'video' => 'travel.mp4',
                'translation_id' => $trans->id,
                'gallery_id' => $id->id,
                'lang_id' => app()->getLocale(),
            ]);
        }
    }
}
