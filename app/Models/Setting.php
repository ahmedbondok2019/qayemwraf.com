<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'app_name' => 'array',
        'app_meta_title' => 'array',
        'app_meta_desc' => 'array',
        'address' => 'array',
        'factory_address' => 'array',
        'additional_address' => 'array',
        'msg_processing' => 'array',
        'msg_shipped' => 'array',
        'msg_completed' => 'array',
        'msg_cancelled' => 'array',
        'msg_delivered' => 'array',
        'why_choose_us_title' => 'array',
        'why_choose_us_subtitle' => 'array',
        'why_choose_us_items' => 'array',
        'catalog_title' => 'array',
        'catalog_description' => 'array',
        'about_tag' => 'array',
        'about_title' => 'array',
        'about_highlight_text' => 'array',
        'about_description' => 'array',
        'about_stats' => 'array',
        'about_features' => 'array',
        'about_image_1_badge_title' => 'array',
        'about_image_1_badge_subtitle' => 'array',
        'about_image_2_badge' => 'array',
        'about_experience_title' => 'array',
        'about_experience_subtitle' => 'array',
        'facebook_client_id' => 'string',
        'facebook_client_secret' => 'string',
        'facebook_redirect' => 'string',
        'google_client_id' => 'string',
        'google_client_secret' => 'string',
        'google_redirect' => 'string',
        'show_ratings' => 'boolean',
        'enable_reviews' => 'boolean',
    ];

    public static function defaultWhyChooseUsItems()
    {
        return [
            [
                'id' => 1,
                'icon' => 'shield_check',
                'title' => [
                    'ar' => 'خامات متينة وتحمل أوزان ثقيلة',
                    'en' => 'Heavy-Duty Steel & High Load Capacity',
                ],
                'description' => [
                    'ar' => 'صاج وشاسيهات بأعلى سماكة محسوبة هندسياً لتتحمل أثقل البضائع وتعيش في ضغط التشغيل اليومي.',
                    'en' => 'Heavy-gauge steel frames precisely engineered to withstand maximum loads and demanding daily warehouse operations.',
                ],
            ],
            [
                'id' => 2,
                'icon' => 'award',
                'title' => [
                    'ar' => 'تصميم هندسي محسوب بدقة',
                    'en' => 'Custom Engineered Storage Solutions',
                ],
                'description' => [
                    'ar' => 'دراسة كاملة لنوع بضائعك، أوزانها، وطريقة مناولتها لنقدّم النظام الأنسب لمخزنك دون عشوائية أو هدر.',
                    'en' => 'Customized rack design based on your pallet sizes, cargo weights, and material handling equipment.',
                ],
            ],
            [
                'id' => 3,
                'icon' => 'maximize',
                'title' => [
                    'ar' => 'استغلال ذكي لمساحة المخزن',
                    'en' => 'Smart Warehouse Space Optimization',
                ],
                'description' => [
                    'ar' => 'بنستغل كل متر من الأرض للسقف بتصميم مدروس يضاعف طاقتك الاستيعابية ويسهّل حركة البضائع والمعدات.',
                    'en' => 'Maximizing floor-to-ceiling storage space to double your warehouse capacity and streamline workflow.',
                ],
            ],
            [
                'id' => 4,
                'icon' => 'wrench',
                'title' => [
                    'ar' => 'تركيب احترافي وتسليم على المفتاح',
                    'en' => 'Turnkey Installation & Safe Delivery',
                ],
                'description' => [
                    'ar' => 'فريق فني متمرس يضمن تركيباً متزناً 100% ومثبتاً بأمان، لتستلم مخزنك جاهزاً للتشغيل فوراً دون قلق.',
                    'en' => 'Professional on-site assembly ensuring 100% alignment, robust anchoring, and immediate operational readiness.',
                ],
            ],
        ];
    }

    public function getWhyChooseUsFormatted($locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        $rawItems = $this->why_choose_us_items;

        if (empty($rawItems) || ! is_array($rawItems)) {
            $rawItems = self::defaultWhyChooseUsItems();
        }

        $formattedItems = [];
        foreach ($rawItems as $index => $item) {
            $titleVal = $item['title'] ?? '';
            if (is_array($titleVal)) {
                $title = $titleVal[$locale] ?? $titleVal['ar'] ?? $titleVal['en'] ?? '';
            } else {
                $title = $titleVal;
            }

            $descVal = $item['description'] ?? '';
            if (is_array($descVal)) {
                $description = $descVal[$locale] ?? $descVal['ar'] ?? $descVal['en'] ?? '';
            } else {
                $description = $descVal;
            }

            $formattedItems[] = [
                'id' => $item['id'] ?? ($index + 1),
                'icon' => $item['icon'] ?? 'shield_check',
                'title' => $title,
                'description' => $description,
            ];
        }

        return [
            'title' => $this->translate('why_choose_us_title', $locale) ?: ($locale === 'en' ? 'Why Choose Qayem & Raf?' : 'لماذا تختار قايم ورف؟'),
            'subtitle' => $this->translate('why_choose_us_subtitle', $locale) ?: ($locale === 'en' ? 'Integrated storage and racking solutions engineered for heavy loads, maximum space utilization, and ultimate safety.' : 'حلول تخزين هندسية متكاملة مصممة لتحمل أقصى الأحمال واستغلال مساحة مخزنك بالكامل بأعلى معايير الأمان.'),
            'items' => $formattedItems,
        ];
    }

    public static function defaultAboutSection()
    {
        return [
            'tag' => [
                'ar' => 'عن قائم ورف',
                'en' => 'About Qayem Wraf',
            ],
            'title' => [
                'ar' => 'الرائدون في تقديم أنظمة وحلول التخزين المعدني المتكاملة',
                'en' => 'Leaders in providing integrated metal storage solutions and systems',
            ],
            'highlight_text' => [
                'ar' => 'أنظمة وحلول التخزين',
                'en' => 'metal storage solutions',
            ],
            'description' => [
                'ar' => 'شركة قائم ورف متخصصة في تصميم، تصنيع، وتوريد كافة حلول التخزين والمستلزمات المعدنية للمخازن والشركات والمصانع. نلتزم بأعلى معايير المتانة والسلامة لتوفير بيئة تخزين منظمة وفعالة تلبي تطلعات عملائنا.',
                'en' => 'Qayem Wraf specializes in the design, manufacturing, and supply of all metal storage solutions and equipment for warehouses, companies, and factories. We adhere to the highest standards of durability and safety to provide an organized and efficient storage environment that meets our clients expectations.',
            ],
            'stats' => [
                ['value' => '15+', 'label' => ['ar' => 'عاماً خبرة', 'en' => 'Years Experience']],
                ['value' => '5000+', 'label' => ['ar' => 'مشروع مكتمل', 'en' => 'Completed Projects']],
                ['value' => '100%+', 'label' => ['ar' => 'رضا العملاء', 'en' => 'Client Satisfaction']],
                ['value' => '50+', 'label' => ['ar' => 'مهندس وفني', 'en' => 'Engineers & Techs']],
            ],
            'features' => [
                [
                    'icon' => 'shield',
                    'title' => ['ar' => 'جودة فائقة ومضمونة', 'en' => 'Superior & Guaranteed Quality'],
                    'description' => ['ar' => 'تصنيع طبقاً لأعلى معايير السلامة والجودة العالمية باستخدام أفضل أنواع الصلب.', 'en' => 'Manufactured according to the highest international safety and quality standards using the finest steel.'],
                ],
                [
                    'icon' => 'truck',
                    'title' => ['ar' => 'توصيل وتركيب سريع', 'en' => 'Fast Delivery & Installation'],
                    'description' => ['ar' => 'فريق متخصص في التوصيل والتركيب الاحترافي لضمان أقصى درجات الثبات والأمان.', 'en' => 'A dedicated team for professional delivery and installation to ensure maximum stability and safety.'],
                ],
                [
                    'icon' => 'headset',
                    'title' => ['ar' => 'استشارات وحلول مخصصة', 'en' => 'Consultations & Custom Solutions'],
                    'description' => ['ar' => 'نقدم دراسات هندسية وتصاميم تخزين تناسب مساحتك واحتياجاتك الفعالة.', 'en' => 'We offer engineering studies and storage designs tailored to your space and specific operational needs.'],
                ],
            ],
            'image_1' => 'storage/uploads/projects/project_6aaef103e75ee_2.webp',
            'image_1_badge_title' => ['ar' => 'تجهيز مستودعات', 'en' => 'Warehouse Setup'],
            'image_1_badge_subtitle' => ['ar' => 'أنظمة تخزين متطورة', 'en' => 'Advanced Storage Systems'],
            'image_2' => 'storage/uploads/projects/project_6aaef147950c9_18.webp',
            'image_2_badge' => ['ar' => 'دراسات هندسية', 'en' => 'Engineering Studies'],
            'image_3' => 'storage/uploads/projects/project_6aaef1cd45146_12.webp',
            'experience_years' => '15+',
            'experience_title' => ['ar' => 'عاماً من الخبرة', 'en' => 'Years of Experience'],
            'experience_subtitle' => ['ar' => 'ثقة متجددة مع كبرى الشركات والمستودعات في مصر', 'en' => 'Renewed trust with top companies and warehouses in Egypt'],
        ];
    }

    public function getAboutSectionFormatted($locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        $defaults = self::defaultAboutSection();

        $tag = $this->translate('about_tag', $locale) ?: ($defaults['tag'][$locale] ?? $defaults['tag']['ar']);
        $title = $this->translate('about_title', $locale) ?: ($defaults['title'][$locale] ?? $defaults['title']['ar']);
        $highlight = $this->translate('about_highlight_text', $locale) ?: ($defaults['highlight_text'][$locale] ?? $defaults['highlight_text']['ar']);
        $description = $this->translate('about_description', $locale) ?: ($defaults['description'][$locale] ?? $defaults['description']['ar']);

        // Stats
        $rawStats = $this->about_stats;
        if (empty($rawStats) || ! is_array($rawStats)) {
            $rawStats = $defaults['stats'];
        }
        $formattedStats = [];
        foreach ($rawStats as $st) {
            $lbl = $st['label'] ?? '';
            $lblText = is_array($lbl) ? ($lbl[$locale] ?? $lbl['ar'] ?? $lbl['en'] ?? '') : $lbl;
            $formattedStats[] = [
                'value' => $st['value'] ?? '',
                'label' => $lblText,
            ];
        }

        // Features
        $rawFeatures = $this->about_features;
        if (empty($rawFeatures) || ! is_array($rawFeatures)) {
            $rawFeatures = $defaults['features'];
        }
        $formattedFeatures = [];
        foreach ($rawFeatures as $ft) {
            $t = $ft['title'] ?? '';
            $tText = is_array($t) ? ($t[$locale] ?? $t['ar'] ?? $t['en'] ?? '') : $t;
            $d = $ft['description'] ?? '';
            $dText = is_array($d) ? ($d[$locale] ?? $d['ar'] ?? $d['en'] ?? '') : $d;
            $formattedFeatures[] = [
                'icon' => $ft['icon'] ?? 'shield',
                'title' => $tText,
                'description' => $dText,
            ];
        }

        // Badges & Images
        $img1 = $this->about_image_1 ? asset($this->about_image_1) : asset($defaults['image_1']);
        $img2 = $this->about_image_2 ? asset($this->about_image_2) : asset($defaults['image_2']);
        $img3 = $this->about_image_3 ? asset($this->about_image_3) : asset($defaults['image_3']);

        $img1BadgeTitle = $this->translate('about_image_1_badge_title', $locale) ?: ($defaults['image_1_badge_title'][$locale] ?? $defaults['image_1_badge_title']['ar']);
        $img1BadgeSubtitle = $this->translate('about_image_1_badge_subtitle', $locale) ?: ($defaults['image_1_badge_subtitle'][$locale] ?? $defaults['image_1_badge_subtitle']['ar']);
        $img2Badge = $this->translate('about_image_2_badge', $locale) ?: ($defaults['image_2_badge'][$locale] ?? $defaults['image_2_badge']['ar']);

        $expYears = $this->about_experience_years ?: $defaults['experience_years'];
        $expTitle = $this->translate('about_experience_title', $locale) ?: ($defaults['experience_title'][$locale] ?? $defaults['experience_title']['ar']);
        $expSubtitle = $this->translate('about_experience_subtitle', $locale) ?: ($defaults['experience_subtitle'][$locale] ?? $defaults['experience_subtitle']['ar']);

        return [
            'tag' => $tag,
            'title' => $title,
            'highlight_text' => $highlight,
            'description' => $description,
            'stats' => $formattedStats,
            'features' => $formattedFeatures,
            'image_1' => $img1,
            'image_1_badge_title' => $img1BadgeTitle,
            'image_1_badge_subtitle' => $img1BadgeSubtitle,
            'image_2' => $img2,
            'image_2_badge' => $img2Badge,
            'image_3' => $img3,
            'experience_years' => $expYears,
            'experience_title' => $expTitle,
            'experience_subtitle' => $expSubtitle,
        ];
    }

    public function translate($attribute, $locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        $value = $this->{$attribute};

        if (is_array($value)) {
            return $value[$locale] ?? $value['en'] ?? $value[array_key_first($value)] ?? '';
        }

        return $value;
    }
}

