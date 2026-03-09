<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class VendorsUsersExport implements FromView
{
    public function view(): View
    {
        $users = User::select('name', 'email', 'phone', 'password', 'created_at', 'updated_at')->distinct('name')
            ->whereNotNull('phone')->get();
        $vendors = Vendor::whereNotNull('phone')->distinct('name')->get();

        return view('export_all_users', [
            'users' => $users,
            'vendors' => $vendors,
        ]);
    }
}
