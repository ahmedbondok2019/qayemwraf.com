<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Http\Resources\ApiV1\OfferResource;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Traits\ApiPaginationTrait;

/**
 *  العروض الترويجية والبنرات
 * 
 * يتولى جلب قائمة العروض الخاصة والبنرات الترويجية النشطة في النظام.
 */
class OfferController extends Controller
{
    use ApiResponseTrait, ApiPaginationTrait;

    /**
     * جلب العروض الخاصة
     * 
     * يعيد قائمة بجميع العروض الترويجية النشطة المتاحة.
     */
    public function index()
    {
        $offers = Offer::active()->with(['translation', 'category.translation'])->get();

        return $this->successResponse(OfferResource::collection($offers));
    }
}
