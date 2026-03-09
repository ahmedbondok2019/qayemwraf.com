<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PrivacyController extends BackendController
{
    public function index()
    {
        if (! in_array('112', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $data['privacy'] = Setting::select('privacy')->where('lang_id', app()->getLocale())->first();

        return view('dashboard.admin.privacy.index', $data);
    }

    public function update(Request $request)
    {
        if (! in_array('112', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $validator = Validator::make($request->all(), [
            'privacy' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect('admin-2023/privacy/index')->withErrors($validator)->withInput();
        }

        $data = Setting::where('lang_id', app()->getLocale())->first();
        if (empty($data)) {
            $data = new Setting;
        }

        $data->privacy = $request->privacy == null ? '' : $request->privacy;
        $data->save();

        alert()->success(trans_db('dashboard.saved'), trans_db('dashboard.congratulation'));

        return redirect(\LaravelLocalization::localizeUrl('admin-2023/privacy/all'));
    }
}
