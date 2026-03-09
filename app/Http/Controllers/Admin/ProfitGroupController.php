<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\profit_groups\CreateProfitGroupRequest;
use App\Http\Requests\profit_groups\UpdateProfitGroupRequest;
use App\Models\ProfitGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProfitGroupController extends BackendController
{
    public function index()
    {
        if (! in_array('85', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data['groups'] = ProfitGroup::all();

        return view('dashboard.admin.profit_groups.index', $data);
    }

    public function create()
    {
        if (! in_array('86', Session::get('permissionData'))) {
            return redirect()->back();
        }

        return view('dashboard.admin.profit_groups.create');
    }

    public function edit(Request $request)
    {
        if (! in_array('87', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data['details'] = ProfitGroup::where('id', $request->id)->firstOrFail();

        return view('dashboard.admin.profit_groups.edit', $data);
    }

    public function store(CreateProfitGroupRequest $request)
    {
        if (! in_array('82', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $data = self::storeCurrencyTranslations($request);
        if ($data == true) {
            alert()->success(trans_db('dashboard.saved'), trans_db('dashboard.congratulation'));

            return redirect('/admin-2023/profit_group/all');
        } else {
            alert()->error(trans_db('dashboard.notsaved'), trans_db('dashboard.attention'));

            return redirect('/admin-2023/profit_group/create');
        }
    }

    public static function storeCurrencyTranslations(Request $request)
    {
        ProfitGroup::create([
            'title' => $request->title,
            'value' => $request->value,
            'type' => $request->type,
        ]);

        return true;
    }

    public function update(UpdateProfitGroupRequest $request)
    {
        if (! in_array('87', Session::get('permissionData'))) {
            return redirect()->back();
        }
        if (is_numeric($request->id)) {
            $data = self::updateCurrencyTranslations($request);

            if ($data == true) {
                alert()->success(trans_db('dashboard.saved'), trans_db('dashboard.congratulation'));
            } else {
                alert()->error(trans_db('dashboard.notsaved'), trans_db('dashboard.attention'));
            }

            return redirect('/admin-2023/profit_group/edit/'.$request->id);

        } else {
            alert()->error(trans_db('dashboard.User Id Wrong', trans_db('dashboard.attention')));

            return redirect()->back();
        }
    }

    public static function updateCurrencyTranslations(Request $request)
    {
        $test = ProfitGroup::where('id', $request->id)->first();

        if ($test) {
            $test->update([
                'title' => $request->title,
                'value' => $request->value,
                'type' => $request->type,
            ]);

            return true;
        }

        return false;

    }

    public function delete(Request $request)
    {
        if (! in_array('88', Session::get('permissionData'))) {
            return redirect()->back();
        }
        ProfitGroup::where('id', $request->id)->delete();

        alert()->success(trans_db('dashboard.deleted'), trans_db('dashboard.congratulation'));

        return redirect('admin-2023/profit_group/all');
    }
}
