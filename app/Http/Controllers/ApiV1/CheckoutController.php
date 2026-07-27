<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderStatus;
use App\Models\UserAddress;
use App\Models\PaymentMethod;
use App\Models\ShippingRule;
use App\Models\OrderSetting;
use App\Models\Coupon;
use App\Models\OrderService as OrderServiceModel;
use App\Models\OrderServiceItem;
use App\Models\Setting;
use App\Models\User;
use App\Services\OrderService;
use App\Traits\ApiResponseTrait;
use App\Traits\ApiPaginationTrait;
use App\Http\Requests\ApiV1\Checkout\CheckoutSummaryRequest;
use App\Http\Requests\ApiV1\Checkout\CheckoutStoreRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Models\Admin;
use App\Models\Vendor;
use App\Notifications\OrderNotification;
use App\Http\Controllers\helper\HelperController;

/**
 *  إنهاء الشراء وإنشاء الطلبات
 * 
 * يتولى حساب إجمالي ملخص الطلب وشامل مصاريف الشحن والخصومات والخدمات الإضافية،
 * والتحقق من صحة وتطبيق كوبونات الخصم، وتأكيد وإنشاء الطلبات الجديدة للمستخدم.
 */
class CheckoutController extends Controller
{
    use ApiResponseTrait, ApiPaginationTrait;

    /**
     * حساب ملخص إنهاء الشراء
     * 
     * يحسب إجمالي المبلغ المطلوب للطلب شاملاً السعر الفرعي للمنتجات، مصاريف الشحن، 
     * خصومات طرق الدفع، خصم الكوبون، وإجمالي الخدمات الإضافية.
     */
    public function summary(CheckoutSummaryRequest $request)
    {
        $userId = $request->user('sanctum') ? $request->user('sanctum')->id : null;
        $tempUserId = $request->temp_user_id;

        $cartItems = Cart::where(function($q) use ($userId, $tempUserId) {
                if ($userId) $q->where('user_id', $userId);
                else $q->where('temp_user_id', $tempUserId);
            })->with('product')->get();

        if ($cartItems->isEmpty()) {
            return $this->errorResponse(__('frontend.your_cart_is_empty'), 400);
        }

        $summary = $this->calculateOrderBreakdown($request, $cartItems);

        return $this->successResponse($summary);
    }

    /**
     * تأكيد وإنشاء الطلب
     * 
     * ينشئ طلباً جديداً في النظام بناءً على عناصر سلة التسوق والعنوان وطريقة الدفع المحددة، 
     * ويفرّغ سلة التسوق الحالية للمستخدم.
     */
    public function store(CheckoutStoreRequest $request)
    {
        $userId = $request->user('sanctum') ? $request->user('sanctum')->id : null;
        $tempUserId = $request->temp_user_id;

        if (!$userId) {
             return $this->errorResponse(__('frontend.please_login_first'), 401);
        }

        $cartItems = Cart::where('user_id', $userId)->with('product')->get();
        if ($cartItems->isEmpty()) {
            return $this->errorResponse(__('frontend.your_cart_is_empty'), 400);
        }

        $breakdown = $this->calculateOrderBreakdown($request, $cartItems);
        
        if (isset($breakdown['error'])) {
            return $this->errorResponse($breakdown['error'], 400);
        }

        $addressId = $request->address_id ?: ($breakdown['address_id'] ?? null);
        if (!$addressId) {
            return $this->errorResponse(__('frontend.please_select_address'), 400);
        }

        $address = UserAddress::findOrFail($addressId);
        $paymentMethod = PaymentMethod::find($request->payment_method_id);

        DB::beginTransaction();
        try {
            $parts = explode(' ', $address->name ?? $request->user()->name, 2);
            $firstName = $parts[0] ?? '';
            $lastName = $parts[1] ?? '';

            $order = Order::create([
                'user_id' => $userId,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $request->user()->email,
                'phone' => $address->phone,
                'address' => $address->address,
                'governorate_id' => $address->governorate_id,
                'city_id' => $address->city_id,
                'zip_code' => '',
                'subtotal' => $breakdown['subtotal'],
                'total' => $breakdown['total'],
                'discount' => round($breakdown['coupon_discount'] + $breakdown['payment_discount'], 2),
                'tax' => 0,
                'payment_method' => $paymentMethod->name ?? 'COD',
                'payment_status' => 'pending',
                'status' => 'pending',
                'currency' => $breakdown['currency'],
                'exchange_rate' => $breakdown['exchange_rate'],
                'note' => $request->note,
                'coupon_code' => $breakdown['coupon_code'],
            ]);

            foreach ($cartItems as $item) {
                [$flashPrice] = OrderService::getFlashSaleValue($item->product_id);
                $finalPrice = ($flashPrice > 0) ? $flashPrice : ($item->product->special_price ?: $item->product->price);
                
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $finalPrice,
                    'subtotal' => $finalPrice * $item->quantity,
                    'rate' => $breakdown['exchange_rate'],
                ]);
            }

            if (!empty($breakdown['selected_services_ids'])) {
                $services = OrderServiceModel::whereIn('id', $breakdown['selected_services_ids'])->get();
                foreach ($services as $service) {
                    OrderServiceItem::create([
                        'order_id' => $order->id,
                        'order_service_id' => $service->id,
                        'price' => $service->price,
                    ]);
                }
            }

            OrderStatus::create([
                'order_id' => $order->id,
                'user_id' => $userId,
                'status' => 'pending',
                'notes' => 'تم إنشاء الطلب عبر تطبيق الجوال',
            ]);

            Cart::where('user_id', $userId)->delete();
            
            if ($breakdown['coupon_code']) {
                Coupon::where('code', $breakdown['coupon_code'])->increment('usage_count');
            }

            $setting = Setting::first();
            $giftPageUnlocked = false;
            if ($setting && $setting->min_order_for_gift && $breakdown['total'] >= $setting->min_order_for_gift) {
                User::where('id', $userId)->update(['gift_page_enabled' => 1]);
                $giftPageUnlocked = true;
            }

            DB::commit();

            try {
                $admins = HelperController::getAllowedAdmins(null, ['57', '58', '59', '60']);
                if (count($admins) > 0) {
                    Notification::send($admins, new OrderNotification($order));
                }

                $vendors = Vendor::whereHas('products', function ($query) use ($order) {
                    $query->whereHas('orderDetails', function ($q) use ($order) {
                        $q->where('order_id', $order->id);
                    });
                })->get();

                if (count($vendors) > 0) {
                    Notification::send($vendors, new OrderNotification($order));
                }
            } catch (\Exception $e) {
                Log::error('Order notification failed: ' . $e->getMessage());
            }

            return $this->successResponse([
                'order_id' => $order->id,
                'gift_unlocked' => $giftPageUnlocked
            ], 'تم إنشاء الطلب بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse(__('frontend.something_went_wrong') . ': ' . $e->getMessage(), 500);
        }
    }

    /**
     * تطبيق وفحص كود كوبون الخصم
     * 
     * يفحص مدى صلاحية وتأثير كود الكوبون المدخل ويعيد تفاصيل قيمة الخصومات.
     */
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'payment_method_id' => 'nullable|exists:payment_methods,id',
            'temp_user_id' => 'nullable|string',
        ]);

        $coupon = Coupon::active()->where('code', $request->code)->first();

        if (!$coupon) {
            return $this->errorResponse(__('frontend.invalid_coupon'), 400);
        }

        $userId = $request->user('sanctum') ? $request->user('sanctum')->id : null;
        $tempUserId = $request->temp_user_id;
        $cartItems = Cart::where(function($q) use ($userId, $tempUserId) {
                if ($userId) $q->where('user_id', $userId);
                else $q->where('temp_user_id', $tempUserId);
            })->pluck('product_id')->toArray();

        if (!empty($coupon->payment_method_id) && is_array($coupon->payment_method_id)) {
            if (!$request->payment_method_id) {
                return $this->errorResponse(__('frontend.please_select_payment_first'), 400);
            }
            if (!in_array($request->payment_method_id, $coupon->payment_method_id)) {
                return $this->errorResponse(__('frontend.coupon_not_valid_for_payment_method'), 400);
            }
        }

        $subtotal = 0;
        $cartItems = Cart::where(function($q) use ($userId, $tempUserId) {
                if ($userId) $q->where('user_id', $userId);
                else $q->where('temp_user_id', $tempUserId);
            })->with('product')->get();

        foreach ($cartItems as $item) {
            [$flashPrice] = OrderService::getFlashSaleValue($item->product_id);
            $price = ($flashPrice > 0) ? $flashPrice : ($item->product->special_price ?: $item->product->price);
            $subtotal += $price * $item->quantity;
        }

        if ($coupon->max_discount && $coupon->max_discount < $subtotal) {
            return $this->errorResponse(__('frontend.coupon_not_valid_for_total', ['amount' => $coupon->max_discount]), 400);
        }

        if (!empty($coupon->product_id) && is_array($coupon->product_id)) {
            $hasValidProduct = false;
            foreach ($cartItems as $pid) {
                if (in_array($pid, $coupon->product_id)) {
                    $hasValidProduct = true;
                    break;
                }
            }
            if (!$hasValidProduct) {
                return $this->errorResponse(__('frontend.coupon_not_valid_for_cart'), 400);
            }
        }

        if ($coupon->usage_limit && $coupon->usage_count >= $coupon->usage_limit) {
            return $this->errorResponse(__('frontend.coupon_limit_reached'), 400);
        }

        return $this->successResponse([
            'code' => $coupon->code,
            'discount_value' => (float)$coupon->discount_value,
            'discount_type' => $coupon->discount_type,
            'max_discount' => (float)$coupon->max_discount,
            'include_shipping' => (bool)$coupon->include_shipping,
            'include_services' => (bool)$coupon->include_services,
        ], __('frontend.coupon_applied_successfully'));
    }

    /**
     * Helper to calculate the breakdown
     */
    private function calculateOrderBreakdown($request, $cartItems)
    {
        $subtotal = 0;
        foreach ($cartItems as $item) {
            [$flashPrice] = OrderService::getFlashSaleValue($item->product_id);
            $price = ($flashPrice > 0) ? $flashPrice : ($item->product->special_price ?: $item->product->price);
            $subtotal += $price * $item->quantity;
        }

        // Shipping
        $shippingCost = 0;
        $addressId = $request->address_id;
        
        $userId = $request->user('sanctum') ? $request->user('sanctum')->id : null;
        if (!$addressId && $userId) {
            $mainAddress = UserAddress::where('user_id', $userId)->where('is_main', 1)->first();
            if ($mainAddress) {
                $addressId = $mainAddress->id;
            }
        }

        $address = $addressId ? UserAddress::find($addressId) : null;
        if ($address) {
            $shippingRule = ShippingRule::where('country_id', $address->country_id)->where('is_active', 1)->first();
            if ($shippingRule) {
                $govRate = $shippingRule->governorateRates()->where('governorate_id', $address->governorate_id)->first();
                if ($govRate) $shippingCost = (float)$govRate->rate;
            }

            // Free shipping check
            $orderSetting = OrderSetting::first();
            if ($orderSetting && $orderSetting->date_from && $orderSetting->date_to) {
                $now = Carbon::now();
                if ($now->between($orderSetting->date_from, $orderSetting->date_to) && $subtotal >= $orderSetting->free_min_amount) {
                    $shippingCost = 0;
                }
            }
        }

        // Services
        $servicesTotal = 0;
        $selectedServicesIds = [];
        if ($request->has('services') && is_array($request->services)) {
            $services = OrderServiceModel::whereIn('id', $request->services)->get();
            $servicesTotal = (float)$services->sum('price');
            $selectedServicesIds = $services->pluck('id')->toArray();
        }

        // Payment Method Discount (Matching Web JS logic)
        $paymentDiscount = 0;
        $paymentMethodId = $request->payment_method_id;
        $paymentMethod = $paymentMethodId ? PaymentMethod::find($paymentMethodId) : null;
        if ($paymentMethod && $paymentMethod->discount > 0) {
            $baseForPaymentDiscount = $subtotal + $shippingCost + $servicesTotal;
            if ($paymentMethod->discount_type === 'percentage') {
                $paymentDiscount = ($baseForPaymentDiscount * $paymentMethod->discount) / 100;
            } else {
                $paymentDiscount = (float)$paymentMethod->discount;
            }
        }

        // Coupon
        $couponDiscount = 0;
        $couponCode = null;
        if ($request->coupon_code) {
            $coupon = Coupon::active()->where('code', $request->coupon_code)->first();
            if ($coupon) {
                $isValid = true;
                
                // Payment restriction
                if (!empty($coupon->payment_method_id) && is_array($coupon->payment_method_id)) {
                    if (!$paymentMethodId || !in_array($paymentMethodId, $coupon->payment_method_id)) $isValid = false;
                }
                
                // Max discount vs Subtotal validation (Exact Web match)
                if ($coupon->max_discount && $coupon->max_discount < $subtotal) $isValid = false;

                if ($isValid) {
                    $discountableTotal = $subtotal;
                    
                    // Product restriction
                    if (!empty($coupon->product_id) && is_array($coupon->product_id)) {
                        $discountableTotal = 0;
                        foreach ($cartItems as $item) {
                            if (in_array($item->product_id, $coupon->product_id)) {
                                [$flashPrice] = OrderService::getFlashSaleValue($item->product_id);
                                $price = ($flashPrice > 0) ? $flashPrice : ($item->product->special_price ?: $item->product->price);
                                $discountableTotal += $price * $item->quantity;
                            }
                        }
                    }

                    if ($coupon->include_shipping) $discountableTotal += $shippingCost;
                    if ($coupon->include_services) $discountableTotal += $servicesTotal;

                    if ($coupon->discount_type === 'percentage') {
                        $couponDiscount = ($discountableTotal * $coupon->discount_value) / 100;
                        if ($coupon->max_discount && $couponDiscount > $coupon->max_discount) {
                            $couponDiscount = (float)$coupon->max_discount;
                        }
                    } else {
                        $couponDiscount = (float)$coupon->discount_value;
                        if ($couponDiscount > $discountableTotal) $couponDiscount = (float)$discountableTotal;
                    }
                    $couponCode = $coupon->code;
                }
            }
        }

        // Web store calculation logic (excludes payment tax as it sets $tax = 0)
        $total = $subtotal + $shippingCost + $servicesTotal - $paymentDiscount - $couponDiscount;

        // Gift Eligibility
        $giftUnlocked = false;
        $setting = Setting::first();
        if ($setting && $setting->min_order_for_gift && $total >= $setting->min_order_for_gift) {
            $giftUnlocked = true;
        }

        return [
            'subtotal' => round($subtotal, 2),
            'shipping_cost' => round($shippingCost, 2),
            'services_total' => round($servicesTotal, 2),
            'payment_discount' => round($paymentDiscount, 2),
            'coupon_discount' => round($couponDiscount, 2),
            'coupon_code' => $couponCode,
            'total' => round(max(0, $total), 2),
            'currency' => session('currency_code', 'EGP'),
            'exchange_rate' => session('exchange_rate', 1),
            'selected_services_ids' => $selectedServicesIds,
            'gift_unlocked' => $giftUnlocked,
            'address_id' => $addressId,
        ];
    }
}
