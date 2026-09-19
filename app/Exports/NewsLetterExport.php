<?php

namespace App\Exports;

use App\Models\Newsletter;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class NewsLetterExport implements FromCollection
{
    /**
     * @return Collection
     */
    public function collection()
    {
        return Newsletter::select('email')->get();
    }
}
