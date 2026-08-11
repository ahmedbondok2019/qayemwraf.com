<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'app_name' => 'array',
        'app_meta_title' => 'array',
        'app_meta_desc' => 'array',
        'address' => 'array',
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
                    'ar' => 'منتجات أصلية 100%',
                    'en' => '100% Original Products',
                ],
                'description' => [
                    'ar' => 'مستوردة مباشرة من المصنعين العالميين المعتمدين.',
                    'en' => 'Imported directly from certified global manufacturers.',
                ],
            ],
            [
                'id' => 2,
                'icon' => 'award',
                'title' => [
                    'ar' => 'موزع رسمي معتمد',
                    'en' => 'Official Authorized Distributor',
                ],
                'description' => [
                    'ar' => 'الوكيل والموزع المعتمد لأكبر ماركات الأجهزة الطبية.',
                    'en' => 'Authorized agent & distributor for top medical device brands.',
                ],
            ],
            [
                'id' => 3,
                'icon' => 'stethoscope',
                'title' => [
                    'ar' => 'استشارات طبية متخصصة',
                    'en' => 'Specialized Medical Consultations',
                ],
                'description' => [
                    'ar' => 'مهندسون متخصصون لمساعدتك في اختيار الجهاز المناسب.',
                    'en' => 'Specialized engineers to assist you in selecting the right device.',
                ],
            ],
            [
                'id' => 4,
                'icon' => 'wrench',
                'title' => [
                    'ar' => 'ضمان وصيانة معتمدة',
                    'en' => 'Certified Warranty & Maintenance',
                ],
                'description' => [
                    'ar' => 'ضمان الوكيل الشامل وتوافر قطع الغيار الأصلية والصيانة.',
                    'en' => 'Comprehensive agent warranty, genuine spare parts, and maintenance.',
                ],
            ],
        ];
    }

    public function getWhyChooseUsFormatted($locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        $rawItems = $this->why_choose_us_items;

        if (empty($rawItems) || !is_array($rawItems)) {
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
            'title' => $this->translate('why_choose_us_title', $locale) ?: ($locale === 'en' ? 'Why choose EG Medical?' : 'لماذا تختار EG Medical؟'),
            'subtitle' => $this->translate('why_choose_us_subtitle', $locale) ?: ($locale === 'en' ? 'We set new standards of reliability and safety in providing medical supplies and equipment' : 'نحن نضع معايير جديدة للموثوقية والأمان في توفير المستلزمات والأجهزة الطبية'),
            'items' => $formattedItems,
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
