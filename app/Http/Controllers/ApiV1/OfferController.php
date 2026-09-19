<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiV1\OfferResource;
use App\Models\Offer;
use App\Traits\ApiPaginationTrait;
use App\Traits\ApiResponseTrait;

/**
 * @group 20. العروض والتخفيضات (Offers)
 *
 * يتولى جلب قائمة العروض الخاصة والبنرات الترويجية النشطة في النظام.
 */
class OfferController extends Controller
{
    use ApiPaginationTrait, ApiResponseTrait;

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
