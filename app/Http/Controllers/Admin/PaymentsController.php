<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PaymentsController extends BackendController
{
    public function index()
    {
        if (! in_array('94', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $data['payments'] = Payment::all();

        return view('dashboard.admin.payments.index', $data);
    }

    public function edit(Request $request)
    {
        if (! in_array('94', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data['payment'] = Payment::where('id', $request->id)->first();

        return view('dashboard.admin.payments.edit', $data);
    }

    public function update(Request $request)
    {
        if (! in_array('94', Session::get('permissionData'))) {
            return redirect()->back();
        }
        if (is_numeric($request->id)) {
            $Payment = Payment::find($request->id);
            if ($Payment) {
                $Payment->update([
                    'payment_ref_id' => $request->payment_ref_id,
                    'notes' => $request->notes,
                    'paid_date' => Carbon::now(),
                ]);
                $status = true;
            } else {
                $status = false;
            }

            if ($status == true) {
                alert()->success(trans_db('dashboard.saved'), trans_db('dashboard.congratulation'));
            } else {
                alert()->error(trans_db('dashboard.notsaved'), trans_db('dashboard.attention'));
            }

            return redirect('/admin-2023/payments/edit/'.$request->id);

        } else {
            alert()->error(trans_db('dashboard.Order Id Wrong', trans_db('dashboard.attention')));

            return redirect()->back();
        }
    }

    public function delete(Request $request)
    {
        if (! in_array('94', Session::get('permissionData'))) {
            return redirect()->back();
        }
        Order::where('id', $request->id)->delete();

        alert()->success(trans_db('dashboard.deleted'), trans_db('dashboard.congratulation'));

        return redirect('admin-2023/orders/all');
    }
}
