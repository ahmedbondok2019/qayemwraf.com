<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Api\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiV1\PageResource;
use App\Models\Page;
use Illuminate\Http\Request;

/**
 *  الصفحات التعريفية والتنظيمية
 * 
 * يتولى جلب قائمة الصفحات العامة في النظام (مثل من نحن، الشروط، سياسة الخصوصية) وتفاصيل صفحة معينة.
 */
class PageController extends Controller
{
    use ApiResponseTrait;

    /**
     * جلب قائمة الصفحات التعريفية
     * 
     * يعيد جميع الصفحات التعريفية النشطة المتاحة في النظام.
     */
    public function index()
    {
        $pages = Page::active()->get();
        return $this->NewApiResponse(PageResource::collection($pages), '', 'true', 200);
    }

    /**
     * جلب تفاصيل صفحة تعريفية بواسطة المعرف أو الرابط الصديق (Slug)
     * 
     * يعيد كامل بيانات ومحتوى صفحة معينة (مثل من نحن أو الشروط والأحكام).
     */
    public function show($slug)
    {
        if (is_numeric($slug)) {
            $page = Page::active()->find($slug);
        } else {
            $page = Page::active()->where('slug', $slug)->first();
            
            if (!$page) {
                $page = Page::active()->whereHas('translations', function($q) use ($slug) {
                    $q->where('slug', $slug);
                })->first();
            }
        }

        if (!$page) {
            return $this->NewApiResponse(null, __('website.Page Not Found'), 'false', 404);
        }

        return $this->NewApiResponse(new PageResource($page), '', 'true', 200);
    }
}
