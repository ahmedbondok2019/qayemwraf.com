<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\promo_code\CreatePromoCodeRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\Promocode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PromoCodeController extends BackendController
{
    public function index()
    {
        if (! in_array('65', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $data['promo_codes'] = Promocode::all();

        return view('dashboard.admin.promo_codes.index', $data);
    }

    public function create()
    {
        if (! in_array('66', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data['products'] = Product::all();

        return view('dashboard.admin.promo_codes.create', $data);
    }

    public function edit(Request $request)
    {
        if (! in_array('67', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data['details'] = Promocode::where('id', $request->id)->first();
        $data['products'] = Product::all();

        return view('dashboard.admin.promo_codes.edit', $data);
    }

    public function store(CreatePromoCodeRequest $request)
    {
        if (! in_array('66', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $data = self::storePromoCode($request);
        if ($data == true) {
            alert()->success(trans_db('dashboard.saved'), trans_db('dashboard.congratulation'));

            return redirect('/admin-2023/promo_code/all');
        } else {
            alert()->error(trans_db('dashboard.notsaved'), trans_db('dashboard.attention'));

            return redirect('/admin-2023/promo_code/create');
        }
    }

    public static function storePromoCode(Request $request)
    {
        Promocode::create([
            'promo_name' => $request->promo_name,
            'promo_code' => $request->promo_code,
            'promoType' => $request->promoType,
            'promoValue' => $request->promoValue,
            'promo_usage_count' => $request->promo_usage_count,
            'promo_oneUse' => $request->promo_oneUse,
            'promoMaxAmount' => $request->promoMaxAmount,
            'promo_valid_from' => $request->promo_valid_from,
            'promo_valid_to' => $request->promo_valid_to,
            'product_id' => str_replace(',', '', $request->product_id),
            'payment_method' => $request->payment_method,
        ]);

        return true;
    }

    public function update(Request $request)
    {
        if (! in_array('67', Session::get('permissionData'))) {
            return redirect()->back();
        }
        if (is_numeric($request->promo_code_id)) {
            $data = self::updatePromoCode($request);
            if ($data == true) {
                alert()->success(trans_db('dashboard.saved'), trans_db('dashboard.congratulation'));
            } else {
                alert()->error(trans_db('dashboard.notsaved'), trans_db('dashboard.attention'));
            }

            return redirect('/admin-2023/promo_code/edit/'.$request->promo_code_id);
        } else {
            alert()->error(trans_db('dashboard.User Id Wrong'), trans_db('dashboard.attention'));

            return redirect()->back();
        }
    }

    public static function updatePromoCode(Request $request)
    {
        $PromoCode = Promocode::find($request->promo_code_id);
        $PromoCode->update([
            'promo_name' => $request->promo_name,
            'promo_code' => $request->promo_code,
            'promoType' => $request->promoType,
            'promoValue' => $request->promoValue,
            'promo_usage_count' => $request->promo_usage_count,
            'promo_oneUse' => $request->promo_oneUse,
            'promoMaxAmount' => $request->promoMaxAmount,
            'promo_valid_from' => $request->promo_valid_from,
            'promo_valid_to' => $request->promo_valid_to,
            'product_id' => str_replace(',', '', $request->product_id),
            'payment_method' => str_replace(',', '', $request->payment_method),
        ]);

        return true;
    }

    public function delete(Request $request)
    {
        if (! in_array('68', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $code = Promocode::where('id', $request->id)->first();
        $testUse = Order::where('coupon_code', $code->promo_code)->first();
        if (empty($testUse)) {
            $code->delete();
            alert()->success(trans_db('dashboard.deleted'), trans_db('dashboard.congratulation'));
        } else {
            alert()->success(trans_db('dashboard.deleted'), trans_db('dashboard.congratulation'));
        }

        return redirect('admin-2023/promo_code/all');
    }
}
