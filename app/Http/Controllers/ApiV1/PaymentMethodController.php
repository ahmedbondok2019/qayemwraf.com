<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Http\Resources\ApiV1\PaymentMethodResource;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

/**
 * @group 24. طرق الدفع (Payment Methods)
 * 
 * يتولى جلب وسائل وطرق الدفع النشطة المتاحة في النظام (الدفع عند الاستلام، بطاقات، تحويل).
 */
class PaymentMethodController extends Controller
{
    use ApiResponseTrait;

    /**
     * جلب طرق الدفع المتاحة
     * 
     * يعيد جميع طرق ووسائل الدفع المتاحة والنشطة في النظام مع تفاصيل الخصومات المتاحة لكل طريقة.
     */
    public function index()
    {
        $methods = PaymentMethod::active()->with(['translation', 'translations'])->get();

        return $this->successResponse(PaymentMethodResource::collection($methods));
    }
}
