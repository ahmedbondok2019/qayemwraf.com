<?php

namespace App\Imports;

use App\Models\Brand;
use App\Models\BrandTranslation;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class BrandImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Brand::create([
                'id' => $row[0],
                'status' => 1,
            ]);

            BrandTranslation::create([
                'title' => strip_tags($row[1]),
                'image' => '',
                'brand_id' => $row[0],
                'lang_id' => 'ar',
            ]);

            BrandTranslation::create([
                'title' => strip_tags($row[1]),
                'image' => '',
                'brand_id' => $row[0],
                'lang_id' => 'en',
            ]);
        }
    }
}
