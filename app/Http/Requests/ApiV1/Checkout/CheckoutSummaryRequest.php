<?php

namespace App\Http\Requests\ApiV1\Checkout;

use App\Http\Requests\ApiV1\BaseApiV1Request;

/**
 * @group 10. ملخص الشراء والخصومات (Checkout & Coupons)
 * 
 * طلب حساب ملخص الشراء وحساب الإجماليات (Checkout Summary Request)
 * 
 * Endpoint: POST /api/v1/checkout/summary
 * 
 * Headers المطلوبة:
 *  - Authorization: Bearer {access_token} (اختياري للزائر، مطلوب للمستخدم المسجل)
 *  - Accept: application/json (مطلوب)
 *  - Content-Type: application/json (مطلوب)
 * 
 * @bodyParam address_id integer optional معرف عنوان الشحن لحساب مصاريف الشحن الدقيقة للمحافظة. Example: 5
 * @bodyParam payment_method_id integer optional معرف طريقة الدفع لحساب خصم طريقة الدفع. Example: 1
 * @bodyParam coupon_code string optional كود كوبون الخصم المراد تقييم خصمه. Example: SAVE20
 * @bodyParam services integer[] optional مصفوفة معرفات الخدمات الإضافية لحساب قيمتها. Example: [1, 2]
 * @bodyParam temp_user_id string optional معرف الزائر المؤقت في حالة عدم تسجيل الدخول. Example: guest_12345
 */
class CheckoutSummaryRequest extends BaseApiV1Request
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * القواعد والقيود الخاصة ببيانات طلب ملخص الشراء
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'address_id' => 'nullable|exists:user_addresses,id',
            'payment_method_id' => 'nullable|exists:payment_methods,id',
            'coupon_code' => 'nullable|string',
            'services' => 'nullable|array',
            'services.*' => 'exists:order_services,id',
            'temp_user_id' => 'nullable|string',
        ];
    }
}
