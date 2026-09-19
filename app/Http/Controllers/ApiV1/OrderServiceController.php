<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiV1\OrderServiceResource;
use App\Models\OrderService;
use App\Traits\ApiPaginationTrait;
use App\Traits\ApiResponseTrait;

/**
 * @group 23. خدمات الطلبات (Order Services)
 *
 * يتولى جلب قائمة الخدمات الإضافية المتاحة للطلبات (مثل التركيب والضمان الممتد أو الشحن الخاص).
 */
class OrderServiceController extends Controller
{
    use ApiPaginationTrait, ApiResponseTrait;

    /**
     * جلب جميع خدمات الطلبات الإضافية
     *
     * يعيد قائمة بجميع خدمات الطلبات النشطة المتاحة.
     */
    public function index()
    {
        $services = OrderService::active()->get();

        return $this->successResponse(OrderServiceResource::collection($services));
    }
}
