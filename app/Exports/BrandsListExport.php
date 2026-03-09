<?php

namespace App\Exports;

use App\Models\ProductBrand;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BrandsListExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return ProductBrand::with('translations')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name AR',
            'Name EN',
        ];
    }

    public function map($brand): array
    {
        return [
            $brand->id,
            $brand->translations->where('locale', 'ar')->first()->title ?? '',
            $brand->translations->where('locale', 'en')->first()->title ?? '',
        ];
    }
}
