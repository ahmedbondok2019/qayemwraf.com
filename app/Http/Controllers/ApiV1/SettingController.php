<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Http\Resources\ApiV1\SettingResource;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Traits\ApiPaginationTrait;

/**
 * @group 17. الإعدادات العامة (Settings)
 * 
 * يوفر الواجهات الخاصة بجلب معلومات وإعدادات التطبيق، وسائل التواصل الاجتماعي، 
 * الكتالوج الطبي بصيغة PDF، مميزات لماذا تختارنا، وسياسات الاستخدام.
 */
class SettingController extends Controller
{
    use ApiResponseTrait, ApiPaginationTrait;

    /**
     * جلب إعدادات التطبيق التفصيلية
     * 
     * يعيد جميع إعدادات التطبيق وروابط التواصل الاجتماعي وقسم لماذا تختارنا والكتالوج.
     */
    public function index()
    {
        $setting = Setting::first();

        if (!$setting) {
            return $this->errorResponse('الإعدادات غير موجودة', 404);
        }

        return $this->successResponse(new SettingResource($setting));
    }

    /**
     * جلب التكوينات العامة للتطبيق
     * 
     * واجهة مخصصة لتزويد التطبيق بالتكوينات العامة كاللغات، الشروط، سياسة الخصوصية، الكتالوج، وإمكانية التسجيل.
     */
    public function configuration()
    {
        $setting = Setting::first();

        if (!$setting) {
             return response()->json([
                'status' => false,
                'data' => null,
                'error' => 'الإعدادات غير موجودة',
                'code' => '404'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => [
                'social_login' => [
                    'facebook' => true,
                    'google' => true,
                ],
                'accept_sms' => true,
                'accept_email' => true,
                'maintenance' => false,
                'default_lang' => 'ar',
                'about' => $setting->translate('about') ?: 'عن EG Medical',
                'about_image' => asset(\App\Models\Page::active()->whereHas('translations', function($q) { $q->where('slug', 'like', 'about%'); })->value('image') ?? ($setting->logo ?? '')),
                'privacy' => $setting->translate('privacy') ?: 'سياسة الخصوصية',
                'terms' => $setting->translate('terms') ?: 'الشروط والأحكام',
                'contact' => $setting->phone,
                'intro' => [],
                'splash' => [
                    'title' => $setting->translate('app_name') ?: 'EG Medical',
                    'image' => $setting->logo ? asset($setting->logo) : null,
                ],
                'logo' => $setting->logo ? asset($setting->logo) : null,
                'currencey' => 'EGP',
                'why_choose_us' => $setting->getWhyChooseUsFormatted(),
                'catalog_download' => [
                    'title' => $setting->translate('catalog_title') ?: 'حمّل كتالوج المنتجات الطبية الكامل',
                    'description' => $setting->translate('catalog_description') ?: 'استعرض أكثر من 10,000 منتج طبي. مثالي للمستشفيات، العيادات، وطلبات الجملة.',
                    'button_text' => 'تحميل الكتالوج بصيغة PDF',
                    'pdf_url' => $setting->catalog_pdf ? asset($setting->catalog_pdf) : asset('storage/medical_catalog.pdf'),
                ],
            ],
            'error' => null,
            'code' => '200'
        ], 200);
    }
}
