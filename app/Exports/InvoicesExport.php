<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromView;

class InvoicesExport implements FromView
{
    public function view(): View
    {
        $id = Session::get('invoiceID');

        return view('dashboard.admin.orders.pdf', [
            'PdfData' => Order::where('id', $id)->whereHas('order_details')->first(),
        ]);
    }
}
