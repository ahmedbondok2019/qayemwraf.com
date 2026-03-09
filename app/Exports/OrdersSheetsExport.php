<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class OrdersSheetsExport implements WithMultipleSheets
{
    use Exportable;

    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new OrdersExportFirst;
        $sheets[] = new OrdersExportTwo;
        $sheets[] = new OrdersExportThird;

        return $sheets;
    }
}
