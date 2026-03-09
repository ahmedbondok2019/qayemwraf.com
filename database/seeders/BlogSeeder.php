<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogCategoryTranslation;
use App\Models\BlogTranslation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 1. Create Blog Categories
        $categories = [
            [
                'ar' => ['title' => 'أخبار المصاحف', 'description' => 'كل ما هو جديد في عالم طباعة ونشر المصاحف.'],
                'en' => ['title' => 'Mushaf News', 'description' => 'Latest updates in the world of Mushaf printing and publishing.']
            ],
            [
                'ar' => ['title' => 'مقالات دينية', 'description' => 'مقالات وبحوث شرعية قيمة.'],
                'en' => ['title' => 'Religious Articles', 'description' => 'Valuable religious articles and research.']
            ],
            [
                'ar' => ['title' => 'نصائح القراءة', 'description' => 'كيف تطور مهاراتك في قراءة وحفظ القرآن.'],
                'en' => ['title' => 'Reading Tips', 'description' => 'How to improve your Quran reading and memorization skills.']
            ]
        ];

        foreach ($categories as $index => $catData) {
            $category = BlogCategory::create([
                'view_index' => $index,
                'status' => true,
            ]);

            foreach (['ar', 'en'] as $lang) {
                BlogCategoryTranslation::create([
                    'blog_category_id' => $category->id,
                    'title' => $catData[$lang]['title'],
                    'slug' => Str::slug($catData[$lang]['title']),
                    'description' => $catData[$lang]['description'],
                    'lang_id' => $lang,
                ]);
            }

            // 2. Create Blogs for each category
            for ($i = 1; $i <= 3; $i++) {
                $blog = Blog::create([
                    'blog_category_id' => $category->id,
                    'view_index' => $i,
                    'status' => true,
                ]);

                $blogTitles = [
                    'ar' => $catData['ar']['title'] . " - مقال رقم " . $i,
                    'en' => $catData['en']['title'] . " - Post No. " . $i,
                ];

                foreach (['ar', 'en'] as $lang) {
                    BlogTranslation::create([
                        'blog_id' => $blog->id,
                        'title' => $blogTitles[$lang],
                        'slug' => Str::slug($blogTitles[$lang]),
                        'image' => 'news.jpg',
                        'tags' => 'islamic,quran,mushaf',
                        'description' => '<p>هذا نص تجريبي لمحتوى المقال. ' . Str::random(200) . '</p><p>' . Str::random(300) . '</p>',
                        'Author' => 'Admin',
                        'lang_id' => $lang,
                    ]);
                }
            }
        }
    }
}
