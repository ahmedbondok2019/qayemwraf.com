<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\area\CreateAreaRequest;
use App\Models\Area;
use App\Models\AreaTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AreaController extends BackendController
{
    public function index()
    {
        if (! in_array('17', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data['areas'] = Area::all();

        return view('dashboard.admin.areas.index', $data);
    }

    public function create()
    {
        if (! in_array('18', Session::get('permissionData'))) {
            return redirect()->back();
        }

        return view('dashboard.admin.areas.create');
    }

    public function addTrans(Request $request)
    {
        if (! in_array('18', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data['Details'] = Area::where('id', $request->area_id)->first();
        if ($data['Details'] == null) {
            return redirect('/admin-2023/area/all');
        }
        $data['id'] = $request->area_id;

        return view('dashboard.admin.areas.trans', $data);
    }

    public function edit(Request $request)
    {
        if (! in_array('19', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data['details'] = Area::where('id', $request->id)->whereHas('translations')->first();
        if ($data['details'] == null) {
            return redirect('/admin-2023/area/addTrans/'.$request->id);
        }

        return view('dashboard.admin.areas.edit', $data);
    }

    public function store(CreateAreaRequest $request)
    {
        if (! in_array('18', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $data = self::storeAreaTranslations($request);
        if ($data == true) {
            alert()->success(trans_db('dashboard.saved'), trans_db('dashboard.congratulation'));

            return redirect('/admin-2023/area/all');
        } else {
            alert()->error(trans_db('dashboard.notsaved'), trans_db('dashboard.attention'));

            return redirect('/admin-2023/area/create');
        }
    }

    public function addAreaTrans(CreateAreaRequest $request)
    {
        $test = AreaTranslation::where('area_id', $request->area_id)
            ->where('lang_id', app()->getLocale())->first();
        if (isset($test)) {
            alert()->error(trans_db('dashboard.Duplicate_TitleOrLanguage'), trans_db('dashboard.attention'));

            return redirect('/admin-2023/area/addTrans/'.$request->area_id);
        }

        $data = self::storeAreaTranslations($request, 'trans');
        if ($data == true) {
            alert()->success(trans_db('dashboard.saved'), trans_db('dashboard.congratulation'));

            return redirect('/admin-2023/area/all');
        } else {
            alert()->error(trans_db('dashboard.notsaved'), trans_db('dashboard.attention'));

            return redirect('/admin-2023/area/addTrans/'.$request->area_id);
        }
    }

    public static function storeAreaTranslations(Request $request, $type = null)
    {
        if ($type == null) {
            $CreateArea = Area::create([
                'lang_id' => app()->getLocale(),
            ]);
        }

        if ($type != null) {
            $CreateArea = Area::findOrFail($request->area_id);
        }
        AreaTranslation::create([
            'title' => strip_tags($request->title),
            'shipping_time' => strip_tags($request->shipping_time),
            'area_id' => isset($CreateArea) ? $CreateArea->id : $request->area_id,
            'lang_id' => app()->getLocale(),
        ]);

        return true;
    }

    public function update(Request $request)
    {
        if (! in_array('19', Session::get('permissionData'))) {
            return redirect()->back();
        }
        if (is_numeric($request->area_id)) {
            $data = self::updateAreaTranslations($request);

            if ($data == true) {
                alert()->success(trans_db('dashboard.saved'), trans_db('dashboard.congratulation'));
            } else {
                alert()->error(trans_db('dashboard.notsaved'), trans_db('dashboard.attention'));
            }

            return redirect('/admin-2023/area/edit/'.$request->area_id);

        } else {
            alert()->error(trans_db('dashboard.User Id Wrong', trans_db('dashboard.attention')));

            return redirect()->back();
        }
    }

    public static function updateAreaTranslations(Request $request)
    {
        $Area = Area::find($request->area_id);
        $Area->update([
            'lang_id' => app()->getLocale(),
        ]);

        $Trans = AreaTranslation::where('area_id', $request->area_id)
            ->where('lang_id', app()->getLocale());
        $Trans->update([
            'title' => strip_tags($request->title),
            'shipping_time' => strip_tags($request->shipping_time),
            'area_id' => $Area->id,
            'lang_id' => app()->getLocale(),
        ]);

        return true;
    }

    public function delete(Request $request)
    {
        if (! in_array('20', Session::get('permissionData'))) {
            return redirect()->back();
        }
        Area::where('id', $request->id)->delete();

        alert()->success(trans_db('dashboard.deleted'), trans_db('dashboard.congratulation'));

        return redirect('admin-2023/area/all');
    }
}
