<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    /**
     * @return Collection
     */
    public function collection()
    {
        return User::select('name', 'email', 'phone')->get();

    }
}
