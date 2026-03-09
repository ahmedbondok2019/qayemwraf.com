<?php

namespace App\Http\Controllers\Vendor;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentsController extends VendorBackendController
{
    public function index()
    {
        $data['payments'] = Payment::where('vendor_id', Auth::id())->get();

        return view('dashboard.vendor.payments.index', $data);
    }

    public function edit(Request $request)
    {
        $data['payment'] = Payment::where('id', $request->id)->where('vendor_id', Auth::id())->firstOrFail();

        return view('dashboard.vendor.payments.edit', $data);
    }
}
