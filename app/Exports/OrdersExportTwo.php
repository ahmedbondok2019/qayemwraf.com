<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromView;

class OrdersExportTwo implements FromView
{
    public function view(): View
    {
        return view('orders_export.second_sheet');
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
