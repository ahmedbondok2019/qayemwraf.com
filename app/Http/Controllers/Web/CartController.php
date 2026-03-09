<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Services\OrderService;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $userId = $user ? $user->id : null;
        $tempUserId = $request->cookie('temp_user_id');

        $cartItems = Cart::where(function($q) use ($userId, $tempUserId) {
                if ($userId) {
                    $q->where('user_id', $userId);
                } elseif ($tempUserId) {
                    $q->where('temp_user_id', $tempUserId);
                } else {
                    $q->whereRaw('1 = 0');
                }
            })
            ->with(['product.translation'])
            ->get();

        $total = 0;
        $total = 0;
        foreach($cartItems as $item) {
            [$flashPrice, $flashId, $validFrom, $validTo, $flashName] = OrderService::getFlashSaleValue($item->product_id);
            $price = ($flashPrice > 0) ? $flashPrice : ($item->product->special_price ?: $item->product->price);
            $total += $price * $item->quantity;
        }

        return view('frontend.cart.index', compact('cartItems', 'total'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer', // Can be positive or negative
            'action' => 'nullable|in:add,set' // 'add' adds to existing, 'set' sets absolute value (optional, defaulting to add for now which is safer for + / - buttons)
        ]);

        $user = Auth::user();
        $userId = $user ? $user->id : null;
        $tempUserId = null;

        if (!$userId) {
            $tempUserId = $request->cookie('temp_user_id');
            if (!$tempUserId) {
                $tempUserId = (string) Str::uuid();
            }
        }

        // Find existing cart item
        $cartItem = Cart::where('product_id', $request->product_id)
            ->where(function($q) use ($userId, $tempUserId) {
                if ($userId) {
                    $q->where('user_id', $userId);
                } else {
                    $q->where('temp_user_id', $tempUserId);
                }
            })->first();

        $newQuantity = 0;
        $status = true;
        $message = '';
        $actionResult = 'updated';

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $request->quantity;
            
            if ($newQuantity <= 0) {
                $cartItem->delete(); // Remove item
                $message = __('Item removed from cart');
                $actionResult = 'removed';
                $newQuantity = 0;
            } else {
                $cartItem->quantity = $newQuantity;
                $cartItem->save();
                $message = __('Cart updated');
                $actionResult = 'updated';
            }
        } else {
            if ($request->quantity > 0) {
                Cart::create([
                    'user_id' => $userId,
                    'temp_user_id' => $userId ? null : $tempUserId,
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity
                ]);
                $newQuantity = $request->quantity;
                $message = __('Item added to cart');
                $actionResult = 'added';
            }
        }

        // Calculate total items count (sum of quantities) for header
        $cartCount = Cart::where(function($q) use ($userId, $tempUserId) {
            if ($userId) {
                $q->where('user_id', $userId);
            } else {
                $q->where('temp_user_id', $tempUserId);
            }
        })->sum('quantity');

        // Calculate total price for summary updates
        $cartItems = Cart::where(function($q) use ($userId, $tempUserId) {
                if ($userId) {
                    $q->where('user_id', $userId);
                } else {
                    $q->where('temp_user_id', $tempUserId);
                }
            })
            ->with('product')
            ->get();

        $cartTotal = 0;
        $cartTotal = 0;
        foreach($cartItems as $item) {
            [$flashPrice, $flashId, $validFrom, $validTo, $flashName] = OrderService::getFlashSaleValue($item->product_id);
            $price = ($flashPrice > 0) ? $flashPrice : ($item->product->special_price ?: $item->product->price);
            $cartTotal += $price * $item->quantity;
        }

        $response = response()->json([
            'status' => true,
            'message' => $message,
            'cart_count' => $cartCount,
            'cart_total' => number_format($cartTotal, 2) . ' ج.م',
            'item_quantity' => $newQuantity,
            'action_result' => $actionResult
        ]);

        if (!$userId && !$request->cookie('temp_user_id')) {
            $response->withCookie(cookie('temp_user_id', $tempUserId, 60 * 24 * 30));
        }

        return $response;
    }
}
