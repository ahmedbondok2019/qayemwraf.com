<?php

namespace App\Http\Requests\ApiV1\Checkout;

use App\Http\Requests\ApiV1\BaseApiV1Request;

/**
 * @group 10. ملخص الشراء والخصومات (Checkout & Coupons)
 * 
 * طلب إنشاء وتأكيد طلب شراء جديد (Checkout Store Request)
 * 
 * Endpoint: POST /api/v1/checkout/store
 * 
 * Headers المطلوبة:
 *  - Authorization: Bearer {access_token} (مطلوب)
 *  - Accept: application/json (مطلوب)
 *  - Content-Type: application/json (مطلوب)
 * 
 * @bodyParam payment_method_id integer required معرف طريقة الدفع المختارة (مثل: 1 للـ COD، أو الدفع الإلكتروني). Example: 1
 * @bodyParam address_id integer optional معرف عنوان الشحن الخاص بالمستخدم. في حال عدم إرساله، يتم استخدام العنوان الرئيسي (is_main=1). Example: 5
 * @bodyParam coupon_code string optional كود كوبون الخصم المراد تطبيقه على الطلب إن وجد. Example: SAVE20
 * @bodyParam services integer[] optional مصفوفة معرفات الخدمات الإضافية المطلوبة مع الطلب. Example: [1, 2]
 * @bodyParam note string optional ملاحظات أو تعليمات خاصة بالطلب (أقصى حد 500 حرف). Example: يرجى الاتصال قبل التوصيل
 * @bodyParam temp_user_id string optional معرف الزائر المؤقت في حالة الدمج. Example: guest_12345
 */
class CheckoutStoreRequest extends BaseApiV1Request
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * القواعد والقيود الخاصة ببيانات طلب إنشاء الأوردر
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'payment_method_id' => 'required|exists:payment_methods,id',
            'address_id' => 'nullable|exists:user_addresses,id',
            'coupon_code' => 'nullable|string',
            'services' => 'nullable|array',
            'services.*' => 'exists:order_services,id',
            'note' => 'nullable|string|max:500',
            'temp_user_id' => 'nullable|string',
        ];
    }
}
