<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Http\Resources\ApiV1\OrderResource;
use App\Traits\ApiResponseTrait;
use App\Traits\ApiPaginationTrait;
use Illuminate\Http\Request;

/**
 * @group User Orders
 * 
 * APIs for managing and viewing user orders.
 */
class OrderController extends Controller
{
    use ApiResponseTrait, ApiPaginationTrait;

    /**
     * Get User Orders
     * 
     * Returns a paginated list of orders for the authenticated user.
     * 
     * @authenticated
     * @queryParam status string Filter by status (e.g., pending, processing, completed, all). Example: pending
     * @queryParam type string Filter by type (regular or gift). Example: regular
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Order::where('user_id', $user->id);

        // Filter by Status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by Type (Gift vs Regular)
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
     * Get Order Details
     * 
     * Returns detailed information about a specific order.
     * 
     * @authenticated
     * @urlParam id int required The ID of the order.
     */
    public function show($id, Request $request)
    {
        $user = $request->user();
        $order = Order::where('user_id', $user->id)
            ->with(['order_details.product.translation', 'order_details.product.brand.translation', 'city.translation', 'governorate.translation', 'order_statuses'])
            ->find($id);

        if (!$order) {
            return $this->errorResponse('Order not found', 404);
        }

        return $this->successResponse(new OrderResource($order));
    }

    /**
     * Cancel Order
     * 
     * @authenticated
     * @urlParam id int required The ID of the order.
     */
    public function cancel(Request $request)
    {
        $user = $request->user();
        $order = Order::where('user_id', $user->id)->find($request->id);

        if (!$order) {
            return $this->errorResponse(__('website.Order Not Found'), 404);
        }

        if ($order->status != 0) { // Only pending orders can be cancelled
            return $this->errorResponse(__('website.Order cannot be cancelled'), 400);
        }

        $order->status = 4; // Cancelled
        $order->save();

        // Log status change if needed, usually via observer or direct create
        // $order->order_statuses()->create(['status' => 4]);

        return $this->successResponse(new OrderResource($order), __('website.Order Cancelled Successfully'));
    }
}
