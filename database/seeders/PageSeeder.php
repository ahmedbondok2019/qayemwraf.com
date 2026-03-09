<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\PageTranslation;
use Illuminate\Support\Str;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = [
            [
                'order' => 1,
                'translations' => [
                    'en' => [
                        'title' => 'About Us',
                        'content' => '<p>Welcome to our bookstore. We offer a wide range of books for all ages.</p>',
                        'slug' => 'about-us',
                        'meta_title' => 'About Us - Bookstore',
                        'meta_description' => 'Learn more about our mission and values.',
                        'meta_keywords' => 'about, bookstore, mission',
                    ],
                    'ar' => [
                        'title' => 'من نحن',
                        'content' => '<p>مرحبًا بكم في مكتبتنا. نحن نقدم مجموعة واسعة من الكتب لجميع الأعمار.</p>',
                        'slug' => 'about-us-ar',
                        'meta_title' => 'من نحن - المكتبة',
                        'meta_description' => 'تعرف على المزيد حول رسالتنا وقيمنا.',
                        'meta_keywords' => 'من نحن, مكتبة, رسالة',
                    ]
                ]
            ],
            [
                'order' => 2,
                'translations' => [
                    'en' => [
                        'title' => 'Privacy Policy',
                        'content' => '<p>Your privacy is important to us. This policy explains how we handle your data.</p>',
                        'slug' => 'privacy-policy',
                        'meta_title' => 'Privacy Policy',
                        'meta_description' => 'Read our privacy policy.',
                        'meta_keywords' => 'privacy, policy, data',
                    ],
                    'ar' => [
                        'title' => 'سياسة الخصوصية',
                        'content' => '<p>خصوصيتك مهمة بالنسبة لنا. تشرح هذه السياسة كيفية تعاملنا مع بياناتك.</p>',
                        'slug' => 'privacy-policy-ar',
                        'meta_title' => 'سياسة الخصوصية',
                        'meta_description' => 'اقرأ سياسة الخصوصية الخاصة بنا.',
                        'meta_keywords' => 'خصوصية, سياسة, بيانات',
                    ]
                ]
            ],
            [
                'order' => 3,
                'translations' => [
                    'en' => [
                        'title' => 'Terms and Conditions',
                        'content' => '<p>Please read these terms and conditions carefully before using our service.</p>',
                        'slug' => 'terms-conditions',
                        'meta_title' => 'Terms and Conditions',
                        'meta_description' => 'Our terms of service.',
                        'meta_keywords' => 'terms, conditions, service',
                    ],
                    'ar' => [
                        'title' => 'الشروط والأحكام',
                        'content' => '<p>يرجى قراءة هذه الشروط والأحكام بعناية قبل استخدام خدمتنا.</p>',
                        'slug' => 'terms-conditions-ar',
                        'meta_title' => 'الشروط والأحكام',
                        'meta_description' => 'شروط الخدمة الخاصة بنا.',
                        'meta_keywords' => 'شروط, أحكام, خدمة',
                    ]
                ]
            ]
        ];

        foreach ($pages as $data) {
            // Find page by English slug to check existence
            $enSlug = $data['translations']['en']['slug'];
            $existingTranslation = PageTranslation::where('slug', $enSlug)->first();
            $page = $existingTranslation ? Page::find($existingTranslation->page_id) : null;

            if (!$page) {
                $page = Page::create([
                    'image' => null, 
                    'is_active' => true,
                    'sort_order' => $data['order'],
                ]);
            } else {
                $page->update([
                    'is_active' => true,
                    'sort_order' => $data['order'],
                ]);
            }

            foreach ($data['translations'] as $locale => $transData) {
                PageTranslation::updateOrCreate([
                    'slug' => $transData['slug'], // Use slug to find existing translation and prevent unique error
                ], [
                    'page_id' => $page->id,
                    'locale' => $locale,
                    'title' => $transData['title'],
                    'content' => $transData['content'],
                    'meta_title' => $transData['meta_title'],
                    'meta_description' => $transData['meta_description'],
                    'meta_keywords' => $transData['meta_keywords'],
                ]);
            }
        }
    }
}
