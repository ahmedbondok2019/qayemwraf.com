<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\CategoryTranslation;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing categories to avoid duplicates if run multiple times (optional, but good for testing)
        // Category::truncate(); // Be careful with truncate if you have foreign key constraints, maybe just leave it adding new ones.

        $categories = [
            [
                'en' => ['title' => 'Islamic Books', 'description' => 'All kinds of Islamic books including Quran, Hadith, and Fiqh.'],
                'ar' => ['title' => 'كتب إسلامية', 'description' => 'جميع أنواع الكتب الإسلامية بما في ذلك القرآن والحديث والفقه.'],
                'children' => [
                    [
                        'en' => ['title' => 'The Holy Quran', 'description' => 'Different prints and translations of the Holy Quran.'],
                        'ar' => ['title' => 'القرآن الكريم', 'description' => 'طبعات وترجمات مختلفة للقرآن الكريم.'],
                    ],
                    [
                        'en' => ['title' => 'Hadith', 'description' => 'Collections of Prophetic Traditions.'],
                        'ar' => ['title' => 'الحديث الشريف', 'description' => 'مجموعات الأحاديث النبوية الشريفة.'],
                    ],
                    [
                        'en' => ['title' => 'Fiqh & Sharia', 'description' => 'Islamic Jurisprudence and Law books.'],
                        'ar' => ['title' => 'الفقه والشريعة', 'description' => 'كتب الفقه الإسلامي والشريعة.'],
                    ],
                    [
                        'en' => ['title' => 'Islamic History', 'description' => 'Books covering the history of Islam.'],
                        'ar' => ['title' => 'التاريخ الإسلامي', 'description' => 'كتب تغطي تاريخ الإسلام.'],
                    ],
                ]
            ],
            [
                'en' => ['title' => 'Literature & Fiction', 'description' => 'Novels, stories, and literary works.'],
                'ar' => ['title' => 'الأدب والروايات', 'description' => 'روايات، قصص، وأعمال أدبية.'],
                'children' => [
                    [
                        'en' => ['title' => 'Arabic Novels', 'description' => 'Contemporary and classic Arabic novels.'],
                        'ar' => ['title' => 'روايات عربية', 'description' => 'روايات عربية معاصرة وكلاسيكية.'],
                    ],
                    [
                        'en' => ['title' => 'International Literature', 'description' => 'Translated international literary works.'],
                        'ar' => ['title' => 'أدب عالمي', 'description' => 'أعمال أدبية عالمية مترجمة.'],
                    ],
                    [
                        'en' => ['title' => 'Poetry', 'description' => 'Collections of poems from various eras.'],
                        'ar' => ['title' => 'الشعر', 'description' => 'دواوين شعرية من عصور مختلفة.'],
                    ],
                ]
            ],
            [
                'en' => ['title' => 'Children\'s Books', 'description' => 'Books suitable for children of all ages.'],
                'ar' => ['title' => 'كتب الأطفال', 'description' => 'كتب مناسبة للأطفال من جميع الأعمار.'],
                'children' => [
                    [
                        'en' => ['title' => 'Educational Stories', 'description' => 'Stories that teach moral values.'],
                        'ar' => ['title' => 'قصص تعليمية', 'description' => 'قصص تعلم القيم الأخلاقية.'],
                    ],
                    [
                        'en' => ['title' => 'Activity Books', 'description' => 'Coloring and puzzle books.'],
                        'ar' => ['title' => 'كتب أنشطة', 'description' => 'كتب تلوين وألغاز.'],
                    ],
                ]
            ],
            [
                'en' => ['title' => 'Self Development', 'description' => 'Books for personal growth and productivity.'],
                'ar' => ['title' => 'تطوير الذات', 'description' => 'كتب للنمو الشخصي والإنتاجية.'],
                'children' => []
            ],
            [
                'en' => ['title' => 'Science & Technology', 'description' => 'Books regarding modern science and tech.'],
                'ar' => ['title' => 'العلوم والتكنولوجيا', 'description' => 'كتب تتعلق بالعلوم الحديثة والتكنولوجيا.'],
                'children' => []
            ],
        ];

        foreach ($categories as $catData) {
            $parent = Category::create([
                'parent_id' => null, // Root category
                'image' => '/_fixed/categories.jpg',     // You can add dummy image paths if you have them
                'is_active' => true,
                'sort_order' => 0,
            ]);

            foreach (['en', 'ar'] as $locale) {
                CategoryTranslation::create([
                    'category_id' => $parent->id,
                    'locale' => $locale,
                    'title' => $catData[$locale]['title'],
                    'description' => $catData[$locale]['description'],
                    'slug' => Str::slug($catData['en']['title'] . '-' . $locale), // Unique slug
                    'meta_title' => $catData[$locale]['title'],
                    'meta_description' => $catData[$locale]['description'],
                    'meta_keywords' => str_replace(' ', ',', $catData[$locale]['title']),
                ]);
            }

            if (!empty($catData['children'])) {
                foreach ($catData['children'] as $childData) {
                    $child = Category::create([
                        'parent_id' => $parent->id,
                        'image' => '/_fixed/subcategories.jpg',
                        'is_active' => true,
                        'sort_order' => 0,
                    ]);

                    foreach (['en', 'ar'] as $locale) {
                        CategoryTranslation::create([
                            'category_id' => $child->id,
                            'locale' => $locale,
                            'title' => $childData[$locale]['title'],
                            'description' => $childData[$locale]['description'],
                            'slug' => Str::slug($childData['en']['title'] . '-' . $locale),
                            'meta_title' => $childData[$locale]['title'],
                            'meta_description' => $childData[$locale]['description'],
                            'meta_keywords' => str_replace(' ', ',', $childData[$locale]['title']),
                        ]);
                    }
                }
            }
        }
    }
}
