<?php

namespace App\Http\Controllers\Admin;

use App\Models\OrderSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ShippingSettingController extends BackendController
{
    public function index(Request $request)
    {
        if (! in_array('134', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data['Setting'] = OrderSetting::first();

        return view('dashboard.admin.shipping_setting.index', $data);
    }

    public function update(Request $request)
    {
        if (! in_array('136', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $validator = Validator::make($request->all(), [
            'free_min_amount' => 'nullable|string',
            'multi_shipping_cost' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect('admin-2023/order_setting/all')->withErrors($validator)->withInput();
        }

        $data = OrderSetting::first();
        if (empty($data)) {
            $data = new OrderSetting;
        }

        $data->free_min_amount = $request->free_min_amount;
        $data->multi_shipping_cost = $request->multi_shipping_cost;
        $data->save();

        alert()->success(trans_db('dashboard.saved'), trans_db('dashboard.congratulation'));

        return redirect('/admin-2023/order_setting/all');
    }
}
