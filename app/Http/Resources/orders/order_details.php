<?php

namespace App\Http\Resources\orders;

use App\Models\ProductTranslation;
use App\Models\Rating;
use App\Models\Vendor;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class order_details extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if ($this->order_id) {
            $isRatedBefore = Rating::where('product_id', $this->product_id)
                ->where('order_id', $this->id)
                ->where('user_id', $this->user_id)
                ->first();
            $trans = ProductTranslation::where('product_id', $this->product_id)->first();

            return [
                'id' => intval($this->id),
                'product_id' => $this->product_id,
                'title' => optional($trans)->title,
                'image' => 'products/'.optional($trans)->primary_image,
                'price' => intval($this->price),
                'quantity' => intval($this->quantity),
                'tax' => floatval($this->tax),
                'discount' => floatval($this->discount),
                'subtotal' => floatval($this->subtotal),
                'vendor' => optional(Vendor::find($this->vendor_id))->name,
                'vendor_address' => optional(Vendor::find($this->vendor_id))->address,
                'rating' => intval(DB::table('ratings')->where('product_id', $this->product_id)->avg('rating')),
                'isRatedBefore' => isset($isRatedBefore) ?? false,
                'date' => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('Y/m/d'),
                'options' => order_options::collection($this->order_details_options),
            ];
        }

        //        return parent::toArray($request);
    }
}
