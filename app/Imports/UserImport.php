<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class UserImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $count = 0;
        foreach ($rows as $row) {
            $count += 1;
            if ($count > 1) {
                User::create([
                    'id' => $row[0],
                    'name' => $row[1].' '.$row[2],
                    'phone' => $row[6] == null ? '010' : $row[6],
                    'email' => $row[3],
                    'image' => '',
                    'status' => $row[18],
                    'customer_group' => $row[8],
                    'password' => $row[4],
                ]);
            }
        }
    }
}
