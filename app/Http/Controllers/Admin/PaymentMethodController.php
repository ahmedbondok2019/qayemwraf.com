<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paymentMethods = PaymentMethod::with('translation')->orderBy('sort_order')->get();
        return view('dashboard.admin.payment_methods.index', compact('paymentMethods'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);
        return view('dashboard.admin.payment_methods.edit', compact('paymentMethod'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'discount' => 'nullable|numeric|min:0',
            'discount_type' => 'nullable|in:percentage,fixed',
            'cod_limit' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
        ]);

        $paymentMethod = PaymentMethod::findOrFail($id);
        
        $paymentMethod->update([
            'discount' => $request->discount ?? 0,
            'discount_type' => $request->discount_type ?? 'percentage',
            'cod_limit' => $request->cod_limit,
            'tax' => $request->tax ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.payment_methods.index')->with('success', trans_db('dashboard.updated'));
    }
}
