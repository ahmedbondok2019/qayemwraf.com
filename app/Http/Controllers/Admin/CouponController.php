<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\PaymentMethod;
use App\Models\Product;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coupons = Coupon::latest()->get();
        return view('dashboard.admin.coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all(); // Assuming Product has translation via accessor or scope?
        // Checking if PaymentMethod has translations, yes.
        $paymentMethods = PaymentMethod::with('translation')->active()->get();
        return view('dashboard.admin.coupons.create', compact('products', 'paymentMethods'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'code' => 'required|string|unique:coupons,code|max:50',
            'discount_value' => 'required|numeric|min:0',
            'discount_type' => 'required|in:percentage,fixed',
            'max_discount' => 'nullable|numeric|min:0',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date|after_or_equal:valid_from',
            'usage_limit' => 'nullable|integer|min:1',
            'usage_limitation' => 'nullable|string',
            'payment_method_id' => 'nullable|array',
            'payment_method_id.*' => 'exists:payment_methods,id',
            'product_id' => 'nullable|array',
            'product_id.*' => 'exists:products,id',
        ]);

        $input = $request->all();
        $input['payment_method_id'] = $request->input('payment_method_id');
        $input['product_id'] = $request->input('product_id');
        $input['include_shipping'] = $request->has('include_shipping');
        $input['include_services'] = $request->has('include_services');

        Coupon::create($input);

        return redirect()->route('admin.coupons.index')->with('success', trans_db('dashboard.saved'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coupon $coupon)
    {
        $products = Product::all();
        $paymentMethods = PaymentMethod::with('translation')->active()->get();
        return view('dashboard.admin.coupons.edit', compact('coupon', 'products', 'paymentMethods'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:coupons,code,' . $coupon->id,
            'discount_value' => 'required|numeric|min:0',
            'discount_type' => 'required|in:percentage,fixed',
            'max_discount' => 'nullable|numeric|min:0',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date|after_or_equal:valid_from',
            'usage_limit' => 'nullable|integer|min:1',
            'usage_limitation' => 'nullable|string',
            'payment_method_id' => 'nullable|array',
            'payment_method_id.*' => 'exists:payment_methods,id',
            'product_id' => 'nullable|array',
            'product_id.*' => 'exists:products,id',
        ]);

        $input = $request->all();
        $input['payment_method_id'] = $request->input('payment_method_id');
        $input['product_id'] = $request->input('product_id');

        if (!$request->has('is_active')) {
            $input['is_active'] = false;
        } else {
             $input['is_active'] = true;
        }

        $input['include_shipping'] = $request->has('include_shipping');
        $input['include_services'] = $request->has('include_services');

        $coupon->update($input);

        return redirect()->route('admin.coupons.index')->with('success', trans_db('dashboard.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('admin.coupons.index')->with('success', trans_db('dashboard.deleted'));
    }
}
