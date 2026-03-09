<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


use App\Models\Order;
use DataTables;

class GiftController extends BackendController
{
    public function index(Request $request)
    {
      

        if ($request->ajax()) {
            $gifts = Order::where('payment_method', 'Gift')
                ->with(['user', 'order_details.product.translation'])
                ->select('orders.*');
            
            return Datatables::of($gifts)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('Y-m-d H:i');
                })
                ->addColumn('user_name', function ($row) {
                    return $row->user ? $row->user->name : __('Unknown');
                })
                ->addColumn('book_name', function ($row) {
                    return $row->order_details->map(function($detail) {
                        return $detail->product->translation->name ?? $detail->product->id;
                    })->implode(', ');
                })
                ->editColumn('status', function ($row) {
                    $statuses = ['pending', 'processing', 'shipped', 'completed', 'cancelled', 'delivered'];
                    // Using helper if available would be better, but hardcoding for now based on OrderStatus
                    $select = '<select class="form-control change-status" data-id="'.$row->id.'">';
                    foreach ($statuses as $status) {
                        $selected = $row->status == $status ? 'selected' : '';
                        $select .= '<option value="'.$status.'" '.$selected.'>'.trans_db('dashboard.'.$status).'</option>';
                    }
                    $select .= '</select>';
                    return $select;
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="'.route('admin.gifts.show', $row->id).'" class="btn btn-primary btn-sm">'.trans_db('dashboard.show').'</a>';
                    return $btn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('dashboard.admin.gifts.index');
    }

    public function updateStatus(Request $request)
    {
   
        $order = Order::find($request->id);
        if ($order) {
            $order->status = $request->status;
            $order->save();

            $setting = \App\Models\Setting::find(1);
            $message = trans_db('dashboard.updated'); // Default message
            
            if ($setting) {
                $statusMsgField = 'msg_' . $request->status;
                if (!empty($setting->$statusMsgField)) {
                    $message = $setting->$statusMsgField;
                }
            }

            if ($order->user) {
                $order->user->notify(new \App\Notifications\GiftStatusUpdated($order, $message, $request->status));
            }

            return response()->json(['success' => true, 'message' => $message]);
        }
        
        return response()->json(['success' => false, 'message' => trans_db('dashboard.error')]);
    }

    public function show($id)
    {
        if (! in_array('57', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $order = Order::with(['order_details.product.translation', 'user'])->findOrFail($id);

        return view('dashboard.admin.gifts.show', compact('order'));
    }
}
