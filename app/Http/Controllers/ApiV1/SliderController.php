<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Http\Resources\ApiV1\SliderResource;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Traits\ApiPaginationTrait;

/**
 *  شرائح العرض (السلايدرز)
 * 
 * يتولى جلب الشرائح والبنرات التفاعلية المتحركة في الصفحة الرئيسية.
 */
class SliderController extends Controller
{
    use ApiResponseTrait, ApiPaginationTrait;

    /**
     * جلب السلايدرز
     * 
     * يعيد قائمة بجميع شرائح العرض النشطة المتاحة مع ترجماتها والأقسام المرتبطة بها.
     */
    public function index()
    {
        $sliders = Slider::active()
            ->with(['translation', 'category'])
            ->get();

        return $this->successResponse(SliderResource::collection($sliders));
    }
}
