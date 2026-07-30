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
 * =========================================================================
 * 📘 دليل المطور (React Frontend Developer Guide):
 * =========================================================================
 * 1. إرسال الطلب (Request):
 *    - يتم إرسال طلب POST مع البيانات الموضحة أدناه مع إضافة ترويسة التوثيق Bearer Token.
 * 
 * 2. استجابة السيرفر (Response Flow):
 *    - إذا كان نوع الدفع "نقداً عند الاستلام" (COD):
 *      تكون الاستجابة تحتوي على { "order_id": 123, "redirect_url": null, "is_online_payment": false }
 *      يقوم تطبيق React بتوجيه المستخدم مباشرة لصفحة تأكيد النجاح (/order-success/123).
 * 
 *    - إذا كان نوع الدفع "أونلاين" (Paymob / Card / Wallet / Online Gateway):
 *      تكون الاستجابة تحتوي على { "order_id": 123, "redirect_url": "https://accept.paymob.com/...", "is_online_payment": true }
 *      يقوم تطبيق React بتوجيه المستخدم إلى `redirect_url` (عبر window.location.href أو iframe) لإكمال عملية الدفع.
 * 
 * 3. عودة العميل بعد الدفع (Post-Payment Redirection):
 *      عند إتمام الدفع أو إغلاقه على بوابة الدفع، تقوم البوابة بتوجيه المتصفح إلى رابط العودة المقترن بالتطبيق:
 *      - في حالة النجاح: /payment/success?order_id=123
 *      - في حالة الفشل: /payment/failed?order_id=123
 * =========================================================================
 * 
 * Headers المطلوبة:
 *  - Authorization: Bearer {access_token} (مطلوب)
 *  - Accept: application/json (مطلوب)
 *  - Content-Type: application/json (مطلوب)
 * 
 * @bodyParam payment_method_id integer required معرف طريقة الدفع المختارة (من API طرق الدفع GET /api/v1/payment-methods). Example: 1
 * @bodyParam address_id integer optional معرف عنوان الشحن الخاص بالمستخدم. في حال عدم إرساله، يتم اختيار العنوان الرئيسي تلقائياً. Example: 5
 * @bodyParam coupon_code string optional كود كوبون الخصم المراد تطبيقه على الطلب إن وجد. Example: SAVE20
 * @bodyParam services integer[] optional مصفوفة معرفات الخدمات الإضافية المطلوبة مع الطلب (مثال: [1, 2]). Example: [1]
 * @bodyParam note string optional ملاحظات أو تعليمات خاصة بالطلب يكتبها العميل (أقصى حد 500 حرف). Example: يرجى الاتصال قبل التوصيل
 * @bodyParam temp_user_id string optional معرف الزائر المؤقت في حالة الدمج. Example: guest_12345
 */
class CheckoutStoreRequest extends BaseApiV1Request
{
    /**
     * تحديد صلاحية تنفيذ الطلب
     */
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
            // معرف طريقة الدفع - إجباري ويجب أن يكون موجوداً في جدول payment_methods
            'payment_method_id' => 'required|exists:payment_methods,id',
            
            // معرف عنوان الشحن - اختياري، وإذا لم يُرسل يتم البحث عن العنوان الرئيسي للمستخدم
            'address_id' => 'nullable|exists:user_addresses,id',
            
            // كود الكوبون - اختياري
            'coupon_code' => 'nullable|string',
            
            // الخدمات الإضافية المختارة - اختياري ويجب أن تكون عناصر المصفوفة موجودة في order_services
            'services' => 'nullable|array',
            'services.*' => 'exists:order_services,id',
            
            // ملاحظات العميل على الطلب - اختياري بحد أقصى 500 حرف
            'note' => 'nullable|string|max:500',
            
            // معرف الزائر المؤقت - اختياري
            'temp_user_id' => 'nullable|string',
        ];
    }

    /**
     * تخصيص الرسائل التوضيحية للأخطاء للفرونت إند
     */
    public function messages(): array
    {
        return [
            'payment_method_id.required' => __('frontend.please_select_payment_first'),
            'payment_method_id.exists'   => __('frontend.invalid_payment_method'),
            'address_id.exists'          => __('frontend.invalid_address'),
            'services.*.exists'          => __('frontend.invalid_service_selected'),
            'note.max'                   => __('frontend.note_too_long'),
        ];
    }
}
