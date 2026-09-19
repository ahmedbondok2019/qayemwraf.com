<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiV1\SliderResource;
use App\Models\Slider;
use App\Traits\ApiPaginationTrait;
use App\Traits\ApiResponseTrait;

/**
 * @group 18. شرائح العرض (Sliders)
 *
 * يتولى جلب الشرائح والبنرات التفاعلية المتحركة في الصفحة الرئيسية.
 */
class SliderController extends Controller
{
    use ApiPaginationTrait, ApiResponseTrait;

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
