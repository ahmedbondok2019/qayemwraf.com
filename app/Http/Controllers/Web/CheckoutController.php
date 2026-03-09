<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderStatus;
use App\Models\UserAddress;
use App\Models\Governorate;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\ShippingRule;
use App\Models\OrderSetting;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ShippingCategoryArea;
use App\Services\OrderService;
use Illuminate\Support\Facades\Notification;
use App\Models\Admin;
use App\Models\Vendor;
use App\Notifications\OrderNotification;
use App\Http\Controllers\helper\HelperController;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $cartItems = Cart::where('user_id', $userId)->with('product.translation')->get();

        if ($cartItems->count() == 0) {
            return redirect()->route('frontend.cart.index')->with('error', trans_db('frontend.your_cart_is_empty'));
        }

        $subtotal = 0;
        foreach ($cartItems as $item) {
            [$flashPrice, $flashId] = OrderService::getFlashSaleValue($item->product_id);
            $price = ($flashPrice > 0) ? $flashPrice : ($item->product->special_price ?: $item->product->price);
            $subtotal += $price * $item->quantity;
        }

        $addresses = UserAddress::where('user_id', $userId)->with(['governorate_rel', 'city_rel'])->get();
        $governorates = Governorate::active()->with('translations')->get();
        $paymentMethods = PaymentMethod::active()->with('translations')->get();
        $orderServices = \App\Models\OrderService::active()->get();
        $coupon = session('coupon');

        return view('frontend.checkout.index', compact('cartItems', 'subtotal', 'addresses', 'governorates', 'paymentMethods', 'orderServices', 'coupon'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:user_addresses,id',
            'payment_method' => 'required|exists:payment_methods,id',
        ]);
        $userId = Auth::id();
        $cartItems = Cart::where('user_id', $userId)->with('product')->get();

        if ($cartItems->count() == 0) {
            return redirect()->route('cart.index')->with('error', trans_db('frontend.your_cart_is_empty'));
        }

        $address = UserAddress::findOrFail($request->address_id);
        $paymentMethod = PaymentMethod::find($request->payment_method); // Get payment method details

        DB::beginTransaction();
        try {
            $subtotal = 0;
            foreach ($cartItems as $item) {
                [$flashPrice, $flashId] = OrderService::getFlashSaleValue($item->product_id);
                $price = ($flashPrice > 0) ? $flashPrice : ($item->product->special_price ?: $item->product->price);
                $subtotal += $price * $item->quantity;
            }

            // Simple shipping calculation (can be improved based on area)
            $shippingCost = 0; 
            $discount = 0; 
            $tax = 0; 

            // Calculate Services Cost
            $servicesTotal = 0;
            $selectedServices = collect();
            if ($request->has('services') && is_array($request->services)) {
                $selectedServices = \App\Models\OrderService::whereIn('id', $request->services)->get();
                $servicesTotal = $selectedServices->sum('price');
            }

            // Decide which total to use for discount
            $discountableTotal = $subtotal;
            if (session()->has('coupon')) {
                $couponData = session('coupon');
                
                // Validate coupon again against subtotal
                if ($couponData['max_discount'] && $couponData['max_discount'] < $subtotal) {
                    Session::forget('coupon');
                    return back()->with('error', trans_db('frontend.coupon_not_valid_for_total', ['amount' => $couponData['max_discount']]));
                }

                // Validate payment method
                if (!empty($couponData['payment_method_id']) && is_array($couponData['payment_method_id'])) {
                    if (!in_array($request->payment_method, $couponData['payment_method_id'])) {
                        Session::forget('coupon');
                        return back()->with('error', trans_db('frontend.coupon_not_valid_for_payment_method'));
                    }
                }

                if (!empty($couponData['product_id']) && is_array($couponData['product_id'])) {
                    $discountableTotal = 0;
                    foreach ($cartItems as $item) {
                        if (in_array($item->product_id, $couponData['product_id'])) {
                            [$flashPrice, $flashId] = OrderService::getFlashSaleValue($item->product_id);
                            $price = ($flashPrice > 0) ? $flashPrice : ($item->product->special_price ?: $item->product->price);
                            $discountableTotal += $price * $item->quantity;
                        }
                    }
                }

                if ($couponData['include_shipping']) {
                    $discountableTotal += $shippingCost;
                }
                if ($couponData['include_services']) {
                    $discountableTotal += $servicesTotal;
                }

                if ($couponData['discount_type'] === 'percentage') {
                    $discount = ($discountableTotal * $couponData['discount_value']) / 100;
                    if ($couponData['max_discount'] && $discount > $couponData['max_discount']) {
                        $discount = $couponData['max_discount'];
                    }
                } else {
                    $discount = $couponData['discount_value'];
                    // Ensure fixed discount doesn't exceed discountable subtotal
                    if ($discount > $discountableTotal) {
                        $discount = $discountableTotal;
                    }
                }
            }

            $total = $subtotal + $shippingCost - $discount + $tax + $servicesTotal;

            // Split name into first and last name
            $parts = explode(' ', $address->name ?? Auth::user()->name, 2);
            $firstName = $parts[0] ?? '';
            $lastName = $parts[1] ?? '';

            $order = Order::create([
                'user_id' => $userId,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => Auth::user()->email,
                'phone' => $address->phone,
                'address' => $address->address,
                'governorate_id' => $address->governorate_id,
                'city_id' => $address->city_id,
                'zip_code' => '', // Add if available
                'subtotal' => $subtotal,
                'total' => $total,
                'discount' => $discount,
                'tax' => $tax,
                'payment_method' => $paymentMethod->name ?? 'COD', // Store name or use ID if preferred, schema says string
                'payment_status' => 'pending',
                'status' => 'pending',
                'currency' => session('currency_code', 'EGP'),
                'exchange_rate' => session('exchange_rate', 1),
                'note' => $request->note,
                'coupon_code' => session('coupon')['code'] ?? null,
            ]);

            foreach ($cartItems as $item) {
                [$flashPrice, $flashId] = OrderService::getFlashSaleValue($item->product_id);
                $finalPrice = ($flashPrice > 0) ? $flashPrice : ($item->product->special_price ?: $item->product->price);
                
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $finalPrice,
                    'subtotal' => $finalPrice * $item->quantity,
                    'rate' => session('exchange_rate', 1), // Standardize field name
                ]);
            }

            // Save Order Services
            foreach ($selectedServices as $service) {
                \App\Models\OrderServiceItem::create([
                    'order_id' => $order->id,
                    'order_service_id' => $service->id,
                    'price' => $service->price,
                ]);
            }

            OrderStatus::create([
                'order_id' => $order->id,
                'user_id' => $userId,
                'status' => 'pending', // Use string to match schema default or enum
                'notes' => 'Order placed via frontend checkout',
            ]);

            Cart::where('user_id', $userId)->delete();
            if (session()->has('coupon')) {
                \App\Models\Coupon::where('code', session('coupon')['code'])->increment('usage_count');
                Session::forget('coupon');
            }

            // Check for Gift Page Eligibility
            $setting = \App\Models\Setting::first();
            $giftPageUnlocked = false;
            if ($setting && $setting->min_order_for_gift && $total >= $setting->min_order_for_gift) {
                $user = \App\Models\User::find($userId);
                $user->update(['gift_page_enabled' => 1]);
                $giftPageUnlocked = true;
            }

            DB::commit();

            try {
                // Notify Admins
                $admins = HelperController::getAllowedAdmins(null, ['57', '58', '59', '60']);
                if (count($admins) > 0) {
                    Notification::send($admins, new OrderNotification($order));
                }

                // Notify Vendors
                $vendors = Vendor::whereHas('products', function ($query) use ($order) {
                    $query->whereHas('orderDetails', function ($q) use ($order) {
                        $q->where('order_id', $order->id);
                    });
                })->get();

                if (count($vendors) > 0) {
                    Notification::send($vendors, new OrderNotification($order));
                }
            } catch (\Exception $e) {
                // Silently fail notification to not break the response
                Log::error('Web Order notification failed: ' . $e->getMessage());
            }

            return redirect()->route('frontend.user.checkout.success', ['order_id' => $order->id])
                             ->with('gift_unlocked', $giftPageUnlocked);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', trans_db('frontend.something_went_wrong') . ': ' . $e->getMessage());
        }
    }

    public function success($order_id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($order_id);
        return view('frontend.checkout.success', compact('order'));
    }

    public function shipping_cost(Request $request)
    {
        if (! auth()->check()) {
            return redirect('login');
        }

        if (! is_numeric($request->address)) {
            return response()->json(['msg' => trans_db('website.invalid data'), 'status' => false]);
        }

        $userId = Auth::id();
        $userCart = Cart::where('user_id', $userId)->with('options')->get(); // Re-query cart for calculation
        $userAddress = UserAddress::find($request->address);
        
        if (!$userAddress) {
             return 0;
        }

        // Calculate Cart Sum for Free Shipping Check
        $cartSum = 0; 
        foreach ($userCart as $cart) {
            [$flashPrice, $flashId] = OrderService::getFlashSaleValue($cart->product_id);
            $price = ($flashPrice > 0) ? $flashPrice : ($cart->product->special_price ?: $cart->product->price);
            // Add option price logic if needed here, assuming basic price for now or consistent with store method
             $cartSum += $price * $cart->quantity;
        }


        // New Shipping Calculation Logic based on ShippingRule (Country & Governorate)
        $shippingCost = 0;
        
        $shippingRule = ShippingRule::where('country_id', $userAddress->country_id)
            ->where('is_active', 1)
            ->first();

        if ($shippingRule) {
            // Find rate for specific governorate
            $govRate = $shippingRule->governorateRates()
                ->where('governorate_id', $userAddress->governorate_id)
                ->first();

            if ($govRate) {
                $shippingCost = $govRate->rate;
            }
        }

        // Free Shipping Logic taking OrderSettings into account
        $order_setting = OrderSetting::first();
        if ($order_setting) {
                if (
                Carbon::now() > Carbon::createFromFormat('Y-m-d H:i:s', $order_setting->date_from) &&
                Carbon::now() < Carbon::createFromFormat('Y-m-d H:i:s', $order_setting->date_to) &&
                $cartSum >= $order_setting->free_min_amount
            ) {
                $shippingCost = 0;
            }
        }

        return $shippingCost;
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'payment_method' => 'nullable|exists:payment_methods,id',
        ]);

        $coupon = \App\Models\Coupon::active()->where('code', $request->code)->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => trans_db('frontend.invalid_coupon'),
            ]);
        }

        // Check if payment method is required first
        if (!empty($coupon->payment_method_id) && is_array($coupon->payment_method_id)) {
            if (!$request->has('payment_method') || empty($request->payment_method)) {
                return response()->json([
                    'success' => false,
                    'message' => trans_db('frontend.please_select_payment_first'),
                ]);
            }

            if (!in_array($request->payment_method, $coupon->payment_method_id)) {
                return response()->json([
                    'success' => false,
                    'message' => trans_db('frontend.coupon_not_valid_for_payment_method'),
                ]);
            }
        }

        // Check product restriction if any
        if (!empty($coupon->product_id) && is_array($coupon->product_id)) {
            $cartItems = Cart::where('user_id', Auth::id())->pluck('product_id')->toArray();
            $hasValidProduct = false;
            foreach ($cartItems as $pid) {
                if (in_array($pid, $coupon->product_id)) {
                    $hasValidProduct = true;
                    break;
                }
            }
            if (!$hasValidProduct) {
                return response()->json([
                    'success' => false,
                    'message' => trans_db('frontend.coupon_not_valid_for_cart'),
                ]);
            }
        }

        // Check usage limit
        if ($coupon->usage_limit && $coupon->usage_count >= $coupon->usage_limit) {
            return response()->json([
                'success' => false,
                'message' => trans_db('frontend.coupon_limit_reached'),
            ]);
        }

        // Calculate Cart Subtotal
        $userId = Auth::id();
        $cartItems = Cart::where('user_id', $userId)->with('product')->get();
        $subtotal = 0;
        foreach ($cartItems as $item) {
            [$flashPrice, $flashId] = \App\Services\OrderService::getFlashSaleValue($item->product_id);
            $price = ($flashPrice > 0) ? $flashPrice : ($item->product->special_price ?: $item->product->price);
            $subtotal += $price * $item->quantity;
        }

        // Check if subtotal exceeds max_discount (as requested by user)
        if ($coupon->max_discount && $coupon->max_discount < $subtotal) {
            return response()->json([
                'success' => false,
                'message' => trans_db('frontend.coupon_not_valid_for_total', ['amount' => $coupon->max_discount]),
            ]);
        }

        // Check payment method restriction if any
        // We will apply it during the total calculation on frontend/backend

        Session::put('coupon', [
            'code' => $coupon->code,
            'discount_value' => $coupon->discount_value,
            'discount_type' => $coupon->discount_type,
            'max_discount' => $coupon->max_discount,
            'product_id' => $coupon->product_id,
            'payment_method_id' => $coupon->payment_method_id,
            'include_shipping' => $coupon->include_shipping,
            'include_services' => $coupon->include_services,
        ]);

        return response()->json([
            'success' => true,
            'message' => trans_db('frontend.coupon_applied_successfully'),
            'coupon' => Session::get('coupon'),
        ]);
    }

    public function removeCoupon()
    {
        Session::forget('coupon');
        return response()->json([
            'success' => true,
            'message' => trans_db('frontend.coupon_removed_successfully'),
        ]);
    }
}
