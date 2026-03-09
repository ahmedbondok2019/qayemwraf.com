<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\CategoryTranslation;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class CategoryImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // $catArray = explode('>' , $row[1]);
            $catArray = explode('>', $row[2]);
            $exists_0 = CategoryTranslation::where('title', trim($catArray[0]))->first();
            if ($exists_0 == null) {
                $Category = self::createCategory($row[0], 0, $catArray[0]);
                $parent1 = $Category->id;
            } else {
                $parent1 = $exists_0->category_id;
            }

            if (isset($catArray[1]) && isset($parent1)) {
                $exists_1 = CategoryTranslation::where('title', trim($catArray[1]))->first();
                if ($exists_1 == null) {
                    $Category1 = self::createCategory($row[0], $parent1, $catArray[1]);
                    $parent2 = $Category1->id;
                } else {
                    $parent2 = $exists_1->category_id;
                }
            }

            if (isset($catArray[2]) && isset($parent2)) {
                $exists_2 = CategoryTranslation::where('title', trim($catArray[2]))->first();
                if (! $exists_2) {
                    self::createCategory($row[0], $parent2, $catArray[2]);
                }
            }
        }
    }

    public static function createCategory($id, $parent, $title1)
    {
        $Category = Category::where('id', $id)->first();
        if (empty($Category)) {
            $Category = Category::create([
                'id' => $id,
                'parent_id' => $parent,
                'image' => 'default.png',
                'view' => '0',
                'lang_id' => 'en',
            ]);
        }

        CategoryTranslation::create([
            'category_id' => $Category->id,
            'categories_id' => $Category->id,
            'title' => trim($title1),
            'color_title' => null,
            'category_parent_id' => $parent,
            'image' => 'default.png',
            'view' => 0,
            'slug' => trim($title1),
            'meta_title' => trim($title1),
            'meta_description' => trim($title1),
            'meta_keywords' => trim($title1),
            'lang_id' => 'en',
        ]);

        return $Category;
    }
}
