<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromView;

class OrdersExportThird implements FromView
{
    public function view(): View
    {
        $IDS = Session::get('orders_id');
        $Order = Order::whereIn('id', $IDS)->get();

        return view('orders_export.export_orders', [
            'orders' => $Order,
        ]);
    }

    // /**
    // * @return \Illuminate\Support\Collection
    // */
    // public function collection()
    // {
    //     $IDS = Session::get('orders_id');
    //     return Order::whereIn('id' , $IDS)->get();

    // }
}
