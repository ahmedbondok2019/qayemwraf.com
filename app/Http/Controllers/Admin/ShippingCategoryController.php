<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\shipping_category\CreateShippingCategoryRequest;
use App\Models\Area;
use App\Models\Category;
use App\Models\Product;
use App\Models\ShippingCategory;
use App\Models\ShippingCategoryArea;
use App\Models\ShippingCategoryTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ShippingCategoryController extends BackendController
{
    public function index()
    {
        if (! in_array('25', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $data['shipping_categories'] = ShippingCategory::all();

        return view('dashboard.admin.shipping_categories.index', $data);
    }

    public function create()
    {
        if (! in_array('26', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data['areas'] = Area::whereHas('translations')->get();
        $data['categories'] = Category::whereHas('CategoryTranslation')->get();

        return view('dashboard.admin.shipping_categories.create', $data);
    }

    public function addTrans(Request $request)
    {
        if (! in_array('26', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data['details'] = ShippingCategory::where('id', $request->shipping_id)->first();
        if ($data['details'] == null) {
            return redirect('/admin-2023/shipping_categories/all');
        }
        $data['id'] = $request->shipping_id;
        $data['areas'] = Area::all();

        return view('dashboard.admin.shipping_categories.trans', $data);
    }

    public function edit(Request $request)
    {
        if (! in_array('27', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data['details'] = ShippingCategory::where('id', $request->id)->whereHas('translations')->whereHas('areas')->first();
        // dd($data['details']->areas);
        if ($data['details']->areas == null) {
            return redirect('/admin-2023/shipping_categories/addTrans/'.$request->id);
        }
        $data['areas'] = Area::whereHas('translations')->get();

        return view('dashboard.admin.shipping_categories.edit', $data);
    }

    public function store(CreateShippingCategoryRequest $request)
    {
        if (! in_array('26', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $data = self::storeShippingTranslations($request);
        if ($data == true) {
            alert()->success(trans_db('dashboard.saved'), trans_db('dashboard.congratulation'));

            return redirect('/admin-2023/shipping_categories/all');
        } else {
            alert()->error(trans_db('dashboard.all data required'), trans_db('dashboard.attention'));

            return redirect('/admin-2023/shipping_categories/create');
        }
    }

    public function addShippingTrans(CreateShippingCategoryRequest $request)
    {
        if (! in_array('26', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $test = ShippingCategoryTranslation::where('shipping_category_id', $request->shipping_id)
            ->where('lang_id', app()->getLocale())->first();
        if (isset($test)) {
            alert()->error(trans_db('dashboard.Duplicate_TitleOrLanguage'), trans_db('dashboard.attention'));

            return redirect('/admin-2023/shipping_categories/addTrans/'.$request->shipping_id);
        }

        $data = self::storeShippingTranslations($request, 'trans');
        if ($data == true) {
            alert()->success(trans_db('dashboard.saved'), trans_db('dashboard.congratulation'));

            return redirect('/admin-2023/shipping_categories/all');
        } else {
            alert()->error(trans_db('dashboard.all data required'), trans_db('dashboard.attention'));

            return redirect('/admin-2023/shipping_categories/addTrans/'.$request->shipping_id);
        }
    }

    public static function storeShippingTranslations(Request $request, $type = null)
    {
        foreach ($request->areas as $key => $value) {
            foreach ($value as $k => $v) {
                if ($request->areas['value'][$k] == '' || $request->areas['value'][$k] == null) {
                    return false;
                }
            }
        }

        if ($type == null) {
            $CreateShipping = ShippingCategory::create([
                'lang_id' => app()->getLocale(),
                'admin_id' => Auth::id(),
                'area_id' => $request->area,
            ]);
        }

        if ($type != null) {
            $CreateShipping = ShippingCategory::findOrFail($request->shipping_id);
        }
        ShippingCategoryTranslation::create([
            'shipping_category_id' => $CreateShipping->id,
            'title' => strip_tags($request->title),
            'slug' => strip_tags($request->slug),
            'admin_id' => Auth::id(),
            'area_id' => $CreateShipping->area_id,
            'lang_id' => app()->getLocale(),
        ]);
        if ($type == null) {
            foreach ($request->areas as $key => $value) {
                foreach ($value as $k => $v) {
                    $test = ShippingCategoryArea::where('area_id', $request->areas['area_id'][$k])
                        ->where('value', $request->areas['value'][$k])->first();
                    if (empty($test)) {
                        ShippingCategoryArea::create([
                            'shipping_category_id' => $CreateShipping->id,
                            'area_id' => $request->areas['area_id'][$k],
                            'value' => $request->areas['value'][$k],
                            'admin_id' => Auth::id(),
                        ]);
                    }
                }
            }
        }

        return true;
    }

    public function update(Request $request)
    {
        if (! in_array('27', Session::get('permissionData'))) {
            return redirect()->back();
        }
        if (is_numeric($request->shipping_id)) {
            $data = self::updateShippingTranslations($request);
            if ($data == true) {
                alert()->success(trans_db('dashboard.saved'), trans_db('dashboard.congratulation'));
            } else {
                alert()->error(trans_db('dashboard.notsaved'), trans_db('dashboard.attention'));
            }

            return redirect('/admin-2023/shipping_categories/edit/'.$request->shipping_id);
        } else {
            alert()->error(trans_db('dashboard.User Id Wrong'), trans_db('dashboard.attention'));

            return redirect()->back();
        }
    }

    public static function updateShippingTranslations(Request $request)
    {
        $ShippingCategory = ShippingCategory::find($request->shipping_id);
        $ShippingCategory->update([
            'lang_id' => app()->getLocale(),
            'admin_id' => Auth::id(),
            'area_id' => $request->area,
        ]);

        ShippingCategoryTranslation::where('shipping_category_id', $request->shipping_id)
            ->where('lang_id', app()->getLocale())
            ->update([
                'shipping_category_id' => $ShippingCategory->id,
                'title' => strip_tags($request->title),
                'slug' => strip_tags($request->slug),
                'admin_id' => Auth::id(),
                'area_id' => $request->area,
                'lang_id' => app()->getLocale(),
            ]);

        foreach ($request->areas as $key => $value) {
            foreach ($value as $k => $v) {
                $ShippingCategoryArea = ShippingCategoryArea::where('area_id', $request->areas['area_id'][$k])
                    ->where('shipping_category_id', $ShippingCategory->id)
                    ->first();
                if (! empty($ShippingCategoryArea)) {
                    $ShippingCategoryArea->update([
                        'value' => $request->areas['value'][$k],
                    ]);
                } else {
                    dd($request->areas['area_id'][$k]);
                }
            }
        }

        return true;
    }

    public function delete(Request $request)
    {
        if (! in_array('28', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $shipping_category = Product::pluck('shipping_category');

        $allowed = ShippingCategory::whereNotIn('id', $shipping_category)->where('id', $request->id)->first();
        if ($allowed) {
            ShippingCategory::where('id', $request->id)->delete();
            ShippingCategoryTranslation::where('shipping_category_id', $request->id)->delete();

            alert()->success(trans_db('dashboard.deleted'), trans_db('dashboard.congratulation'));

            return redirect('admin-2023/shipping_categories/all');
        } else {

            alert()->success(trans_db('dashboard.not allowed to delete used category'), trans_db('dashboard.congratulation'));

            return redirect('admin-2023/shipping_categories/all')->withErrors(['errors' => implode(',', $shipping_category)]);
        }

    }
}
