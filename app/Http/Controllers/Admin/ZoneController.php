<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\zone\CreateZoneRequest;
use App\Models\City;
use App\Models\Zone;
use App\Models\ZoneTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ZoneController extends BackendController
{
    public function index()
    {
        if (! in_array('121', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data['zones'] = Zone::all();

        return view('dashboard.admin.zones.index', $data);
    }

    public function create()
    {
        if (! in_array('122', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data['zones'] = City::all();

        return view('dashboard.admin.zones.create', $data);
    }

    public function addTrans(Request $request)
    {
        if (! in_array('122', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data['Details'] = Zone::where('id', $request->zone_id)->first();
        if ($data['Details'] == null) {
            return redirect('/admin-2023/zone/all');
        }
        $data['id'] = $request->zone_id;
        $data['zones'] = City::all();

        return view('dashboard.admin.zones.trans', $data);
    }

    public function edit(Request $request)
    {
        if (! in_array('123', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data['details'] = Zone::where('id', $request->id)->whereHas('translations')->first();
        if ($data['details'] == null) {
            return redirect('/admin-2023/zone/addTrans/'.$request->id);
        }
        $data['zones'] = City::all();

        return view('dashboard.admin.zones.edit', $data);
    }

    public function store(CreateZoneRequest $request)
    {
        if (! in_array('122', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $data = self::storeZoneTranslations($request);
        if ($data == true) {
            alert()->success(trans_db('dashboard.saved'), trans_db('dashboard.congratulation'));

            return redirect('/admin-2023/zone/all');
        } else {
            alert()->error(trans_db('dashboard.notsaved'), trans_db('dashboard.attention'));

            return redirect('/admin-2023/zone/create');
        }
    }

    public function addZoneTrans(CreateZoneRequest $request)
    {
        if (! in_array('122', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $test = ZoneTranslation::where('parent_id', $request->zone_id)
            ->where('lang_id', app()->getLocale())->first();
        if (isset($test)) {
            alert()->error(trans_db('dashboard.Duplicate_TitleOrLanguage'), trans_db('dashboard.attention'));

            return redirect('/admin-2023/zone/addTrans/'.$request->zone_id);
        }

        $data = self::storeZoneTranslations($request, 'trans');
        if ($data == true) {
            alert()->success(trans_db('dashboard.saved'), trans_db('dashboard.congratulation'));

            return redirect('/admin-2023/zone/all');
        } else {
            alert()->error(trans_db('dashboard.notsaved'), trans_db('dashboard.attention'));

            return redirect('/admin-2023/zone/addTrans/'.$request->zone_id);
        }
    }

    public static function storeZoneTranslations(Request $request, $type = null)
    {
        if ($type == null) {
            $CreateZone = Zone::create([
                'lang_id' => app()->getLocale(),
            ]);
        }

        if ($type != null) {
            $CreateZone = Zone::findOrFail($request->zone_id);
        }
        ZoneTranslation::create([
            'title' => strip_tags($request->title),
            'parent_id' => $CreateZone->parent_id,
            'zone_id' => $CreateZone->id,
            'lang_id' => app()->getLocale(),
        ]);

        return true;
    }

    public function update(Request $request)
    {
        if (! in_array('123', Session::get('permissionData'))) {
            return redirect()->back();
        }
        if (is_numeric($request->zone_id)) {
            $data = self::updateZoneTranslations($request);

            if ($data == true) {
                alert()->success(trans_db('dashboard.saved'), trans_db('dashboard.congratulation'));
            } else {
                alert()->error(trans_db('dashboard.notsaved'), trans_db('dashboard.attention'));
            }

            return redirect('/admin-2023/zone/edit/'.$request->zone_id);

        } else {
            alert()->error(trans_db('dashboard.User Id Wrong', trans_db('dashboard.attention')));

            return redirect()->back();
        }
    }

    public static function updateZoneTranslations(Request $request)
    {
        $Zone = Zone::find($request->zone_id);
        $Zone->update([
            'lang_id' => app()->getLocale(),
        ]);

        $Trans = ZoneTranslation::where('parent_id', $request->zone_id)
            ->where('lang_id', app()->getLocale());
        $Trans->update([
            'title' => strip_tags($request->title),
            'parent_id' => $Zone->parent_id,
            'zone_id' => $Zone->id,
            'lang_id' => app()->getLocale(),
        ]);

        return true;
    }

    public function delete(Request $request)
    {
        if (! in_array('124', Session::get('permissionData'))) {
            return redirect()->back();
        }
        Zone::where('id', $request->id)->delete();

        alert()->success(trans_db('dashboard.deleted'), trans_db('dashboard.congratulation'));

        return redirect('admin-2023/zone/all');
    }
}
