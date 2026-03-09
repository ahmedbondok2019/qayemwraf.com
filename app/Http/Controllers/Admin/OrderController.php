<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Order;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends BackendController
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $orders = Order::with(['user', 'order_details.product.translation'])
                ->select('orders.*');
            
            return DataTables::of($orders)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return $row->created_at ? $row->created_at->format('Y-m-d H:i') : '';
                })
                ->addColumn('user_name', function ($row) {
                    return $row->user ? $row->user->name : ($row->first_name . ' ' . $row->last_name);
                })
                ->addColumn('details', function ($row) {
                    return $row->order_details->map(function($detail) {
                        return ($detail->product->translation->name ?? $detail->product->id) . ' (' . $detail->quantity . ')';
                    })->implode(', ');
                })
                ->editColumn('status', function ($row) {
                    $statuses = ['pending', 'processing', 'shipped', 'completed', 'cancelled', 'delivered'];
                    $select = '<select class="form-control change-status" data-id="'.$row->id.'">';
                    foreach ($statuses as $status) {
                        $selected = $row->status == $status ? 'selected' : '';
                        $select .= '<option value="'.$status.'" '.$selected.'>'.trans_db('dashboard.'.$status).'</option>';
                    }
                    $select .= '</select>';
                    return $select;
                })
                ->addColumn('total_formatted', function($row) {
                    return $row->total . ' ' . ($row->currency ?? 'EGP');
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="'.route('admin.orders.show', $row->id).'" class="btn btn-primary btn-sm">'.trans_db('dashboard.show').'</a>';
                    return $btn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('dashboard.admin.orders.index');
    }

    public function show($id)
    {
        $order = Order::with(['order_details.product.translation', 'user', 'governorate_rel', 'city_rel'])->findOrFail($id);
        return view('dashboard.admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, \App\Services\FirebaseService $firebaseService)
    {
        $order = Order::with('user', 'order_details.product')->findOrFail($request->id);
        $oldStatus = $order->status;
        $newStatus = $request->status;

        $order->status = $newStatus;
        $order->save();

        // Send Firebase Notification if user exists
        if ($order->user) {
            $title = 'تحديث حالة الطلب #' . $order->id;
            $body = 'حالة طلبك الآن هي: ' . __('dashboard.' . $newStatus);
            $firebaseService->sendToUser($order->user, $title, $body, [
                'order_id' => (string)$order->id,
                'type' => 'order_status'
            ]);
        }

        // If status changed to delivered, decrease product quantity
        if ($newStatus == 'delivered' && $oldStatus != 'delivered') {
            foreach ($order->order_details as $detail) {
                $product = $detail->product;
                if ($product && !$product->ignore_quantity) {
                    $product->decrement('quantity', $detail->quantity);
                }
            }
        }
        
        // Optional: If status changed FROM delivered to something else (e.g. cancelled), increase product quantity
        if ($oldStatus == 'delivered' && $newStatus != 'delivered') {
            foreach ($order->order_details as $detail) {
                $product = $detail->product;
                if ($product && !$product->ignore_quantity) {
                    $product->increment('quantity', $detail->quantity);
                }
            }
        }

        return response()->json(['success' => true, 'message' => trans_db('dashboard.updated')]);
    }
}
