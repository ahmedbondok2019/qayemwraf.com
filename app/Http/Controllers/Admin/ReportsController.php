<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ReportsController extends BackendController
{
    public function index(Request $request)
    {
        if (! in_array('38', Session::get('permissionData'))) {
            return redirect()->back();
        }

        switch (\Illuminate\Support\Facades\Request::url()) {
            case \LaravelLocalization::localizeUrl('admin-2023/reports/orders'):
            case \LaravelLocalization::localizeUrl('admin-2023/reports/order_filter'):
                $data = self::reportType($request, 'orders', 'orders', 'order_filter', 'total');

                return view('dashboard.admin.reports.usersOrders', $data);

                //            case \LaravelLocalization::localizeUrl('admin-2023/reports/services'):
                //            case \LaravelLocalization::localizeUrl('admin-2023/reports/service_filter'):
                //                $data = self::reportType($request,'services','services','admin-2023/reports/service_filter', '');
                //                return view('dashboard.admin.reports.services', $data);

                //            case \LaravelLocalization::localizeUrl('admin-2023/reports/invoices'):
                //            case \LaravelLocalization::localizeUrl('admin-2023/reports/invoice_filter'):
                //                $data = self::reportType($request,'invoices','invoices','admin-2023/reports/invoice_filter' , 'total_amount');
                //                return view('dashboard.admin.reports.invoices', $data);
                //
                //            case \LaravelLocalization::localizeUrl('admin-2023/reports/due_7'):
                //                $data = self::reportType($request,'invoices','invoices','admin-2023/reports/due_7' , 'total_amount');
                //                return view('dashboard.admin.reports.due_7', $data);
                //
                //            case \LaravelLocalization::localizeUrl('admin-2023/reports/income'):
                //                $data = self::reportType($request,'invoices','invoices','admin-2023/reports/income' , 'total_amount');
                //                return view('dashboard.admin.reports.income', $data);
                //
                //            case \LaravelLocalization::localizeUrl('admin-2023/reports/appointments'):
                //            case \LaravelLocalization::localizeUrl('admin-2023/reports/appointment_filter'):
                //                $data = self::reportType($request,'appointments','appointments','admin-2023/reports/appointment_filter', '', '', 'appointment_date');
                //                return view('dashboard.admin.reports.appointments', $data);
        }
    }

    public static function reportType(Request $request, $table, $trans, $route, $field, $due_7 = null, $appointment_date = null)
    {
        //        dd($request->all());
        $data['reports'] = self::getReportsTotal($request, $table, $field, $due_7 = null)['reports'];
        $data['trans'] = trans_db('dashboard.'.$trans);
        $data['route'] = $route;
        if ($appointment_date != null) {
            $data['appointment_date'] = $appointment_date;
        } else {
            $data['appointment_date'] = null;
        }
        $data['totalOrder'] = self::getReportsTotal($request, $table, $field)['totalOrder'];

        return $data;
    }

    public static function getReportsTotal(Request $request, $table, $field, $due_7 = null, $appointment_date = null)
    {
        $report = DB::table($table);
        //        if (!empty($request->appointment_date)){
        //            if ($appointment_date == null){
        //                $report = $report->whereDate('created_at', $request->appointment_date);
        //            }else{
        //                $report = $report->whereDate('appointment_date', $request->appointment_date);
        //            }
        //        }

        if (! empty($request->timeRange)) {
            $thisDate = explode(' to ', $request->timeRange);
            $dateFrom = $thisDate[0];
            $dateTo = $thisDate[1];

            $report = $report->whereDate('created_at', '>=', $dateFrom)
                ->whereDate('created_at', '<=', $dateTo);
        }

        //        if ($due_7 != null){
        //            if ($appointment_date == null){
        //                $report = $report->whereDate('created_at', '<', Carbon::today()->subDays(7));
        //            }else{
        //                $report = $report->whereDate('appointment_date', '<', Carbon::today()->subDays(7));
        //            }
        //        }

        if (! empty($field)) {
            $totalOrder = $report
//                $report->whereNotIn('status', ['cancel' , 'refunded'])
                ->sum($field);
        } else {
            $totalOrder = $report->count();
        }

        $reports = $report->orderByDesc('id')->paginate();

        return ['reports' => $reports, 'totalOrder' => $totalOrder];
    }
}
