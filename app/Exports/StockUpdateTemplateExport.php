<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StockUpdateTemplateExport implements FromCollection, WithHeadings
{
    /**
     * @return Collection
     */
    public function collection()
    {
        return collect([
            [
                'sku' => 'PROD-001',
                'quantity' => '10',
            ],
        ]);
    }

    public function headings(): array
    {
        return [
            'sku',
            'quantity',
        ];
    }
}
