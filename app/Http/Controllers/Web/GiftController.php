<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GiftController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user->gift_page_enabled) {
            return redirect()->route('user.home')->with('error', trans_db('frontend.You do not have permission to access the Gift Page.'));
        }

        $gifts = Product::active()->where('is_gift', 1)->with('translation')->paginate(12);
        
        $setting = \App\Models\Setting::first();
        $maxGiftItems = $setting->max_gift_items ?? 1;

        return view('frontend.gifts.index', compact('gifts', 'maxGiftItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'gift_ids' => 'required|array|min:1',
            'gift_ids.*' => 'exists:products,id',
        ]);

        $setting = \App\Models\Setting::first();
        $maxGiftItems = $setting->max_gift_items ?? 1;

        if (count($request->gift_ids) > $maxGiftItems) {
            return back()->with('error', trans_db('frontend.You can only select up to :count gifts.', ['count' => $maxGiftItems]));
        }

        $user = Auth::user();

        // Create a new order for gifts (Price 0)
        // You might want to wrap this in a transaction
        // Assuming standard order creation logic with 0 price
        
        $order = \App\Models\Order::create([
            'user_id' => $user->id,
            'first_name' => $user->name, // parse name if needed
            'email' => $user->email,
            'phone' => $user->phone,
            'address' => 'Gift Request', // Or use default address
            'total' => 0,
            'subtotal' => 0,
            'status' => 'pending',
            'payment_status' => 'paid', // It's a gift
            'payment_method' => 'Gift',
            'note' => 'Gift Request',
            'currency' => session('currency_code', 'EGP'),
            'exchange_rate' => session('exchange_rate', 1),
        ]);

        foreach ($request->gift_ids as $giftId) {
            $product = Product::find($giftId);
            \App\Models\OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $giftId,
                'quantity' => 1,
                'price' => 0,
                'subtotal' => 0,
                'rate' => session('exchange_rate', 1),
            ]);
        }
        
        \App\Models\OrderStatus::create([
            'order_id' => $order->id,
            'user_id' => $user->id,
            'status' => 'pending',
            'notes' => 'Gift request placed',
        ]);
        
        // Disable gift page after claiming
        $user->update(['gift_page_enabled' => 0]); 

        return redirect()->route('frontend.user.gifts.success');
    }

    public function success()
    {
        return view('frontend.gifts.success');
    }
}
