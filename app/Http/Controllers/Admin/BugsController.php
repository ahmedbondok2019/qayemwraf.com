<?php

namespace App\Http\Controllers\Admin;

use App\Models\LogApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class BugsController extends BackendController
{
    public function Index(Request $request)
    {
        if (! in_array('133', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $data['log_apis'] = LogApi::where('type', 'bug')->orderByDesc('id')->paginate(15);

        return view('dashboard.admin.bugs.index', $data);
    }

    public function edit(Request $request)
    {
        if (! in_array('133', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data['log_apis'] = LogApi::where('id', $request->id)
            ->firstorFail();

        return view('dashboard.admin.bugs.edit', $data);
    }

    public function update(Request $request)
    {
        if (! in_array('100', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $validator = Validator::make($request->all(), [
            'id' => 'required|string',
        ]);

        if ($validator->fails()) {
            if ($validator->fails()) {
                return redirect('/admin-2023/bugs/edit/'.$request->id)->withErrors($validator)->withInput();
            }
        }

        $data = LogApi::where('id', $request->id)->first();
        if (isset($data) && $data != '') {
            $data->update([
                'status' => 1,
                'reply' => $request->reply,
                'reply_user_id' => Auth::user()->id,
            ]);
        }

        alert()->success(trans_db('dashboard.updated'), trans_db('dashboard.congratulation'));

        return redirect('/admin-2023/bugs/all');
    }

    public function delete(Request $request)
    {
        if (! in_array('100', Session::get('permissionData'))) {
            return redirect()->back();
        }
        LogApi::where('id', $request->id)->delete();

        return redirect()->back();
    }

    public static function GetFileStatus($status)
    {
        switch ($status) {
            case 0:
                $trans = trans_db('dashboard.Waiting');
                $style = 'background:#efc6b9';
                break;
            case 1:
                $trans = trans_db('dashboard.Replied');
                $style = 'background:#afe3af';
                break;
        }

        return ['trans' => $trans, 'style' => $style];
    }
}
