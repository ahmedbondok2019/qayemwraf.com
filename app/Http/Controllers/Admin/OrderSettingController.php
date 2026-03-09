<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\OrderSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class OrderSettingController extends BackendController
{
    public function index(Request $request)
    {
        if (! in_array('49', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data['Setting'] = OrderSetting::first();
        $data['categories'] = Category::with('childs')->with('CategoryTranslation')->orderby('view')->get();

        return view('dashboard.admin.order_setting.order_setting', $data);
    }

    public function update(Request $request)
    {
        if (! in_array('50', Session::get('permissionData'))) {
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

        $cat = array_filter(explode(',', $request->categories), fn ($value) => ! is_null($value) && $value !== '');
        $categories = array_unique($cat);

        $dealOfDay = ProductsController::validDate(1, $request->date_from, $request->date_to);

        $data->free_min_amount = $request->free_min_amount;
        $data->multi_shipping_cost = $request->multi_shipping_cost;
        $data->categories = collect($categories)->implode(',');
        $data->date_from = $dealOfDay[0];
        $data->date_to = $dealOfDay[1];
        $data->save();

        alert()->success(trans_db('dashboard.saved'), trans_db('dashboard.congratulation'));

        return redirect('/admin-2023/order_setting/all');
    }
}
