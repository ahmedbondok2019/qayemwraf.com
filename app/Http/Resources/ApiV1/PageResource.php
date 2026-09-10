<?php

namespace App\Http\Resources\ApiV1;

use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $imageUrl = $this->image ? asset($this->image) : null;
        $isAbout = str_starts_with($this->slug, 'about') || ($this->id == 1);
        $locale = app()->getLocale();

        $defaultAboutImages = [
            $imageUrl ?: asset('website/images/about/engineering_studies.jpg'),
            asset('website/images/about/warehouse_equipment.jpg'),
            asset('website/images/about/durability_steel.jpg'),
        ];

        $gallery = [
            [
                'image' => $defaultAboutImages[0],
                'title' => $locale === 'en' ? 'Engineering Studies' : 'دراسات هندسية',
            ],
            [
                'image' => $defaultAboutImages[1],
                'title' => $locale === 'en' ? 'Warehouse Equipment - Advanced Storage Systems' : 'تجهيز مستودعات - أنظمة تخزين متطورة',
            ],
            [
                'image' => $defaultAboutImages[2],
                'title' => $locale === 'en' ? 'Highest Standards of Durability & Steel' : 'أعلى معايير المتانة والصلب',
            ],
        ];

        $stats = [
            ['value' => '15+', 'label' => $locale === 'en' ? 'Years of Experience' : 'عاماً خبرة'],
            ['value' => '5000+', 'label' => $locale === 'en' ? 'Completed Projects' : 'مشروع مكتمل'],
            ['value' => '100%+', 'label' => $locale === 'en' ? 'Customer Satisfaction' : 'رضا العملاء'],
            ['value' => '50+', 'label' => $locale === 'en' ? 'Engineers & Technicians' : 'مهندس وفني'],
        ];

        $features = [
            [
                'icon' => 'shield_check',
                'title' => $locale === 'en' ? 'Superior & Guaranteed Quality' : 'جودة فائقة ومضمونة',
                'description' => $locale === 'en' ? 'Manufactured according to the highest global safety and quality standards using the finest types of steel.' : 'تصنيع طبقاً لأعلى معايير السلامة والجودة العالمية باستخدام أفضل أنواع الصلب.',
            ],
            [
                'icon' => 'truck',
                'title' => $locale === 'en' ? 'Fast Delivery & Installation' : 'توصيل وتركيب سريع',
                'description' => $locale === 'en' ? 'Specialized team in professional delivery and installation to ensure maximum stability and safety.' : 'فريق متخصص في التوصيل والتركيب الاحترافي لضمان أقصى درجات الثبات والأمان.',
            ],
            [
                'icon' => 'headphones',
                'title' => $locale === 'en' ? 'Consultations & Custom Solutions' : 'استشارات وحلول مخصصة',
                'description' => $locale === 'en' ? 'We provide engineering studies and storage designs tailored to your space and operational needs.' : 'نقدم دراسات هندسية وتصاميم تخزين تناسب مساحتك واحتياجاتك الفعالة.',
            ],
        ];

        $response = [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title, // Current locale title
            'image' => $imageUrl,
            'images' => $isAbout ? $defaultAboutImages : ($imageUrl ? [$imageUrl] : []),
            'content' => $this->content, // Current locale content
            'translations' => $this->translations->map(function ($translation) {
                return [
                    'locale' => $translation->locale,
                    'title' => $translation->title,
                    'slug' => $translation->slug,
                    'content' => $translation->content,
                    'meta_title' => $translation->meta_title,
                    'meta_description' => $translation->meta_description,
                ];
            }),
        ];

        if ($isAbout) {
            $response['badge'] = $locale === 'en' ? 'About Qayem Wraf' : 'عن قائم ورف';
            $response['stats'] = $stats;
            $response['features'] = $features;
            $response['gallery'] = $gallery;
            $response['experience_card'] = [
                'years' => '15+',
                'title' => $locale === 'en' ? '15+ Years of Experience' : '15+ عاماً من الخبرة',
                'subtitle' => $locale === 'en' ? 'Renewed trust with top companies and warehouses across Egypt.' : 'ثقة متجددة مع كبرى الشركات والمستودعات في مصر.',
            ];
            $response['button'] = [
                'text' => $locale === 'en' ? 'Discover More About Us' : 'اكتشف المزيد عنا',
                'link' => '/about-us',
            ];
        }

        return $response;
    }
}
