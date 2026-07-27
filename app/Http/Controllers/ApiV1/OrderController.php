<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Http\Resources\ApiV1\OrderResource;
use App\Traits\ApiResponseTrait;
use App\Traits\ApiPaginationTrait;
use Illuminate\Http\Request;

/**
 *  طلبيات المستخدم
 * 
 * يتولى جلب قائمة طلبات المستخدم، استعراض تفاصيل طلب محدد، وإلغاء الطلبات القابلة للإلغاء.
 */
class OrderController extends Controller
{
    use ApiResponseTrait, ApiPaginationTrait;

    /**
     * جلب قائمة الطلبات للمستخدم
     * 
     * يعيد قائمة مفلترة ومقسمة صفحات لطلبات المستخدم الحالي.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Order::where('user_id', $user->id);

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('type') && $request->type !== 'all') {
            if ($request->type === 'gift') {
                $query->where('payment_method', 'gift');
            } else {
                $query->where(function($q) {
                    $q->whereNull('payment_method')
                      ->orWhere('payment_method', '!=', 'gift');
                });
            }
        }

        $orders = $query->latest()->paginate(10);

        return $this->successResponse($this->paginateResponse($orders, OrderResource::collection($orders)));
    }

    /**
     * جلب تفاصيل طلب محدد
     * 
     * يعيد كامل بيانات وتفاصيل المنتج وعنوان الشحن وحالة الطلب لرقم طلب محدد.
     */
    public function show($id, Request $request)
    {
        $user = $request->user();
        $order = Order::where('user_id', $user->id)
            ->with(['order_details.product.translation', 'order_details.product.brand.translation', 'city.translation', 'governorate.translation', 'order_statuses'])
            ->find($id);

        if (!$order) {
            return $this->errorResponse('الطلب غير موجود', 404);
        }

        return $this->successResponse(new OrderResource($order));
    }

    /**
     * إلغاء طلب مسبق
     * 
     * يلغي الطلب المكتوب إذا كان لا يزال في حالة قيد الانتظار ولم يتم تجهيزه أو شحنه بعد.
     */
    public function cancel(Request $request)
    {
        $user = $request->user();
        $order = Order::where('user_id', $user->id)->find($request->id);

        if (!$order) {
            return $this->errorResponse(__('website.Order Not Found'), 404);
        }

        if ($order->status != 0) {
            return $this->errorResponse(__('website.Order cannot be cancelled'), 400);
        }

        $order->status = 4;
        $order->save();

        return $this->successResponse(new OrderResource($order), __('website.Order Cancelled Successfully'));
    }
}
