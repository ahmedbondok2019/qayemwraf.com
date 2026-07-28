<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderStatus;
use App\Http\Resources\ApiV1\ProductResource;
use App\Traits\ApiResponseTrait;
use App\Traits\ApiPaginationTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * @group 14. الهدايا والمكافآت (Gifts)
 * 
 * يتولى استعراض الهدايا المتاحة للمستخدمين المؤهلين والمطالبة بالهدايا المجانية.
 */
class GiftController extends Controller
{
    use ApiResponseTrait, ApiPaginationTrait;

    /**
     * جلب قائمة الهدايا المتاحة
     * 
     * يعيد قائمة بالمنتجات المحددة كـ هدايا للمستخدم في حال تفعيل الصفحة له بناءً على قيمة الطلبات.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if (!$user->gift_page_enabled) {
            return $this->errorResponse(__('frontend.You do not have permission to access the Gift Page.'), 403);
        }

        $gifts = Product::active()->where('is_gift', 1)->with(['translation', 'brand.translation'])->paginate(12);
        
        $setting = Setting::first();
        $maxGiftItems = $setting->max_gift_items ?? 1;

        return $this->successResponse($this->paginateResponse($gifts, ProductResource::collection($gifts), [
            'max_gift_items' => (int)$maxGiftItems,
        ]));
    }

    /**
     * المطالبة بالهدايا المحددة
     * 
     * ينشئ طلباً مجانياً بالهدايا التي اختارها المستخدم بعد استيفاء الشروط.
     */
    public function store(Request $request)
    {
        $request->validate([
            'gift_ids' => 'required|array|min:1',
            'gift_ids.*' => 'exists:products,id',
        ]);

        $user = $request->user();

        if (!$user->gift_page_enabled) {
            return $this->errorResponse(__('frontend.You do not have permission to access the Gift Page.'), 412);
        }

        $setting = Setting::first();
        $maxGiftItems = $setting->max_gift_items ?? 1;

        if (count($request->gift_ids) > $maxGiftItems) {
            return $this->errorResponse(__('frontend.You can only select up to :count gifts.', ['count' => $maxGiftItems]), 422);
        }

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => $user->id,
                'first_name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'address' => 'Gift Request (API)',
                'total' => 0,
                'subtotal' => 0,
                'status' => 'pending',
                'payment_status' => 'paid',
                'payment_method' => 'Gift',
                'note' => 'Gift Request via API',
                'currency' => session('currency_code', 'EGP'),
                'exchange_rate' => session('exchange_rate', 1),
            ]);

            foreach ($request->gift_ids as $giftId) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $giftId,
                    'quantity' => 1,
                    'price' => 0,
                    'subtotal' => 0,
                    'rate' => session('exchange_rate', 1),
                ]);
            }
            
            OrderStatus::create([
                'order_id' => $order->id,
                'user_id' => $user->id,
                'status' => 'pending',
                'notes' => 'Gift request placed via API',
            ]);
            
            $user->update(['gift_page_enabled' => 0]); 

            DB::commit();

            return $this->successResponse([
                'order_id' => $order->id
            ], 'تم اختيار الهدايا بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse(__('frontend.something_went_wrong') . ': ' . $e->getMessage(), 500);
        }
    }
}
