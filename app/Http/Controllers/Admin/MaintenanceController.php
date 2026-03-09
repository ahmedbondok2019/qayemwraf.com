<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;

class MaintenanceController extends BackendController
{
    public function index()
    {
        $data['site_status'] = Setting::first();

        return view('dashboard.admin.maintenance.index', $data);
    }

    public function activatesite(Request $request)
    {
        if ($request->site_status == 1) {
            \Illuminate\Support\Facades\Artisan::call('up');
        } else {
            \Illuminate\Support\Facades\Artisan::call('down --secret="1630542a-246b-4b66-afa1-dd72a4c43666"');
        }

        $site_status = Setting::first();
        if ($site_status) {
            $site_status->update([
                'site_status' => $request->site_status,
            ]);
        }

        alert()->success(trans_db('dashboard.updated'), trans_db('dashboard.congratulation'));

        return redirect('admin-2023/maintenance/all');
    }
}
