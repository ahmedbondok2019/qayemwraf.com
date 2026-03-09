<?php

namespace App\Exports;

use App\Models\Brand;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class BrandsExport implements FromView
{
    public function view(): View
    {
        $brands = Brand::all();

        return view('export_brands', [
            'brands' => $brands,
        ]);
    }
}
