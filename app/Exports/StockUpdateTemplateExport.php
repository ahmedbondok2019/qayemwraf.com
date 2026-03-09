<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StockUpdateTemplateExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect([
            [
                'sku' => 'PROD-001',
                'quantity' => '10'
            ]
        ]);
    }

    public function headings(): array
    {
        return [
            'sku',
            'quantity'
        ];
    }
}
