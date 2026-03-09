<?php

namespace App\Http\Resources\orders;

use App\Http\Controllers\helper\HelperController;
use App\Models\Vendor;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class orders extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => intval($this->id),
            'status_id' => intval($this->status),
            'status' => HelperController::orderStatusApi($this->status)['status'],
            'status_text' => HelperController::orderStatusApi($this->status)['text'],
            'sum' => $this->sum,
            'tax' => $this->tax,
            'total' => $this->total,
            'address' => $this->address,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'payment_status' => $this->payment_status == 0 ? false : true,
            'payment_method' => $this->payment_method,
            'transaction_ref' => $this->transaction_ref,
            'discount_amount' => $this->discount_amount,
            'discount_type' => $this->discount_type,
            'coupon_code' => $this->coupon_code,
            'shipping_cost' => $this->shipping_cost,
            'expected_delivery_date' => $this->expected_delivery_date,
            'delivery_service_name' => $this->delivery_service_name,
            'third_party_delivery_tracking_id' => $this->third_party_delivery_tracking_id,
            // 'vendor_id' => (Vendor::find($this->vendor_id))->name,
            'date' => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('Y/m/d'),
            'order_details' => order_details::collection($this->order_details),
        ];
        //        return parent::toArray($request);
    }
}
