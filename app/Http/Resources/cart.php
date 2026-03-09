<?php

namespace App\Http\Resources;

use App\Http\Controllers\Api\CartController;
use App\Models\Currency;
use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class cart extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $product = Product::active()->where('id', $this->product_id)->whereHas('translations')->whereHas('images')->first();
        if ($product) {
            if ($product->translation) {

                $rate = Currency::where('status', 1)->first()->rate;

                return [
                    'id' => $this->id,
                    'product_id' => $this->product_id,
                    'product' => [
                        'title' => $product->translation['title'],
                        'image' => 'products/'.$product->translation['primary_image'],
                    ],
                    'quantity' => $this->quantity,
                    'price' => number_format($this->price * $rate, 2),
                    'tax' => number_format($this->tax * $rate, 2),
                    'subtotal' => number_format($this->subtotal * $rate, 2),
                    'option_items' => cart_options::collection($this->options),
                    'max_quantity' => intval((CartController::getMaxQuantity($this->product_id, $this->options))['max_quantity']),
                    'ignore_quantity' => boolval(CartController::getMaxQuantity($this->product_id, $this->options)['ignore_quantity']),
                ];
            }
        }
        //        return parent::toArray($request);
    }
}
