<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponseTrait;
use App\Traits\ApiPaginationTrait;
use App\Http\Resources\ApiV1\ProductResource;
use App\Http\Requests\ApiV1\Cart\CartIndexRequest;
use App\Http\Requests\ApiV1\Cart\CartStoreRequest;
use App\Http\Requests\ApiV1\Cart\CartUpdateRequest;

/**
 * @group Cart
 * 
 * APIs for managing the shopping cart
 */
class CartController extends Controller
{
    use ApiResponseTrait, ApiPaginationTrait;
    /**
     * Get Cart Items
     * 
     * Get all items in the cart for the authenticated user or guest.
     * 
     * @bodyParam temp_user_id string Optional. Required if user is not authenticated. Example: guest_123
     */
    public function index(CartIndexRequest $request)
    {
        $query = Cart::with(['product.productOptions.values', 'product.translation']);

        if ($request->user('sanctum')) {
            $query->where('user_id', $request->user('sanctum')->id);
        } else {
            $query->where('temp_user_id', $request->temp_user_id);
        }

        $items = $query->get();
        $total = 0;
        foreach ($items as $item) {
            [$flashPrice] = \App\Services\OrderService::getFlashSaleValue($item->product_id);
            $price = ($flashPrice > 0) ? $flashPrice : ($item->product->special_price ?: $item->product->price);
            $total += $price * $item->quantity;
        }

        return $this->successResponse([
            'items' => $items->map(function($item) {
                return [
                    'id' => $item->id,
                    'quantity' => $item->quantity,
                    'product' => new ProductResource($item->product),
                ];
            }),
            'total' => (float)$total,
            'formatted_total' => format_price($total),
            'currency' => [
                'code' => config('app.currency_code'),
                'symbol' => config('app.currency_symbol'),
                'exchange_rate' => config('app.exchange_rate'),
            ],
        ]);
    }

    /**
     * Add to Cart
     * 
     * Add a product to the cart.
     * 
     * @bodyParam product_id int required The ID of the product. Example: 1
     * @bodyParam quantity int Optional. Default 1. Example: 2
     * @bodyParam temp_user_id string Optional. Required if user is not authenticated. Example: guest_123
     */
    public function store(CartStoreRequest $request)
    {

        $userId = $request->user('sanctum') ? $request->user('sanctum')->id : null;
        $tempUserId = $request->temp_user_id;

        $cartItem = Cart::where('product_id', $request->product_id)
            ->where(function($q) use ($userId, $tempUserId) {
                if ($userId) {
                    $q->where('user_id', $userId);
                } else {
                    $q->where('temp_user_id', $tempUserId);
                }
            })->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $request->quantity ?? 1);
        } else {
            $cartItem = Cart::create([
                'user_id' => $userId,
                'temp_user_id' => $tempUserId,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity ?? 1,
            ]);
        }

        return $this->successResponse($cartItem->load('options'), 'Product added to cart');
    }

    /**
     * Update Cart Item
     * 
     * Update quantity of a cart item.
     * 
     * @urlParam id int required The ID of the cart item.
     * @bodyParam quantity int required The new quantity. Example: 3
     */
    public function update(CartUpdateRequest $request, $id)
    {
        $cartItem = Cart::findOrFail($id);

        $cartItem->update(['quantity' => $request->quantity]);

        return $this->successResponse($cartItem, 'Cart updated');
    }

    /**
     * Delete Cart Item
     * 
     * Remove an item from the cart.
     * 
     * @urlParam id int required The ID of the cart item.
     */
    public function destroy(\Illuminate\Http\Request $request, $id)
    {
        $cartItem = Cart::findOrFail($id);
        $cartItem->delete();

        return $this->successResponse(null, 'Item removed from cart');
    }
}
