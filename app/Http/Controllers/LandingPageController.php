<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Currency;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderStatus;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LandingPageController extends Controller
{
    public function index()
    {
        $data['areas'] = Area::all();
        // جلب كل المنتجات النشطة (status = 1) مع علاقاتها
        $data['products'] = Product::with([
            'Landingtranslations' => function ($q) {
                $q->where('lang_id', App::getLocale());
            },
            'categories.LandingCategoryTranslation' => function ($q) {
                $q->where('lang_id', App::getLocale());
            },
        ])
            ->where('status', 1)
            ->where('show_in_landing', 1)
            ->get();

        $grouped = collect();

        foreach ($data['products'] as $product) {
            $trans = $product->Landingtranslations->first();
            if (! $trans) {
                continue;
            }

            $category = $product->categories->first();
            $categoryTitle = $category
                ? optional($category->LandingCategoryTranslation->first())->title ?? 'غير مصنف'
                : 'غير مصنف';

            $grouped->push([
                'category_title' => $categoryTitle,
                'product' => $product,
                'translation' => $trans,
            ]);
        }

        $data['groupedByCategory'] = $grouped->groupBy('category_title');

        return view('landing-page', $data);
    }

    public function guestOrder(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|digits:11|starts_with:010,011,012,015',
            'userArea' => 'required|exists:areas,id',
            'userCity' => 'required|exists:cities,id',
            'address_line' => 'required|string',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:cash',
        ]);

        $currency = Currency::where('status', 1)->first();
        $rate = $currency->rate;

        // 1. العثور على المستخدم أو إنشاؤه
        $user = \App\Models\User::firstOrCreate(
            ['email' => $request->email],
            [
                'name' => $request->name,
                'phone' => $request->phone,
                'country_code' => '+20',
                'password' => Hash::make(Str::random(12)),
                'status' => 1,
                'accept' => 1,
            ]
        );

        // 2. إضافة العنوان
        $address = \App\Models\UserAddress::create([
            'user_id' => $user->id,
            'city' => $request->userCity, // city = city_id
            'area' => $request->userArea,   // area = area_id
            'address' => $request->address_line,
            'phone' => $request->phone,
            'name' => $request->name,
        ]);

        // 3. جلب المنتج
        $product = \App\Models\Product::findOrFail($request->product_id);
        $price = $product->sale_price ?? $product->price;
        $subtotal = $price * $request->quantity;

        // 4. حساب الشحن (بنفس منطق النظام)
        $shippingCost = \App\Models\ShippingCategoryArea::where('area_id', $request->userArea)
            ->where('shipping_category_id', $product->shipping_category)
            ->first()?->value ?? 50;

        // 5. إنشاء الطلب
        $order = Order::create([
            'user_id' => $user->id,
            'address' => $address->id,
            'tax' => 0,
            'shipping_cost' => $shippingCost,
            'sum' => $subtotal,
            'total' => $subtotal + $shippingCost,
            'payment_method' => 'cash',
            'status' => 0,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'notes' => $request->address_line,
            'area' => $request->userArea,
            'city' => $request->userCity,
        ]);

        // 6. تفاصيل الطلب
        OrderDetail::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'tax' => 0,
            'vendor_id' => $product->vendor_id,
            'quantity' => $request->quantity,
            'price' => $price,
            'rate' => $rate,
            'subtotal' => $subtotal,
        ]);

        OrderStatus::create([
            'order_id' => $order->id,
            'user_id' => $user->id,
            'status' => 0,
            'notes' => $request->address_line,
        ]);

        return response()->json(['success' => true]);
    }
}
