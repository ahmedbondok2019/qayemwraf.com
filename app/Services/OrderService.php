<?php

namespace App\Services;

use App\Http\Controllers\Api\CartController;
use App\Models\FlashSale;
use App\Models\Product;
use App\Models\ProductOptionItem;
use Carbon\Carbon;

class OrderService
{
    public static function getProductOptionItemPrice($cart)
    {
        if (! $cart || ! $cart->product_id) {
            return 0; // Return 0 if cart or product ID is invalid
        }

        $product = Product::find($cart->product_id);
        if (! $product) {
            return 0; // Return 0 if product doesn't exist
        }

        // Get product base price
        $basePrice = CartController::getProductPrice($product->id);
        $price = ($basePrice > 0) ? $basePrice : (floatval($product->sale_price) ?: $product->price);

        // Decode options safely
        $options = json_decode($cart->options, true);
        if (! is_array($options)) {
            return $price; // Return base price if options are invalid
        }

        // Adjust price based on selected options
        foreach ($options as $option) {
            $ProductOptionItem = ProductOptionItem::where([
                'option_id' => $option['option_id'] ?? null,
                'option_item_id' => $option['option_item_id'] ?? null,
                'product_id' => $cart->product_id,
            ])->first();

            if ($ProductOptionItem) {
                $difference = $ProductOptionItem->difference_in_price;
                $price += ($ProductOptionItem->isPluse) ? $difference : -$difference;
            }
        }

        return max(0, $price); // Ensure price doesn't go negative
    }

    public static function getFlashSaleValue($product)
    {
        $value = 0;
        $flash_id = null;
        $valid_from = null;
        $valid_to = null;
        $flash_name = null;
        $active = Product::active()->pluck('id')->toArray();
        $flash_sales = FlashSale::where('start_at', '<=', Carbon::now())
            ->where('end_at', '>=', Carbon::now())
            ->where('is_active', 1)
            ->with(['translation', 'products' => function($q) use ($active) {
                // We could filter pivot here but simpler to load and check in loop given structure
            }])
            ->get();

        foreach ($flash_sales as $sale) {
             // Access products via relation, not sale_products property which might be old
            $sale_products = $sale->products; 
            if ($sale_products->count() > 0) {
                foreach ($sale_products as $pro) {
                    if (is_array($active)) {
                        if (in_array($pro->id, $active)) { // $pro->id is product id in many-to-many
                            if ($product === $pro->id) {
                                $value = $pro->pivot->price; // Access pivot price
                                $flash_id = $sale->id;
                                $valid_from = $sale->start_at;
                                $valid_to = $sale->end_at;
                                $flash_name = $sale->translation->name ?? $sale->name; // Get name
                                
                                // Return immediately on first valid match? 
                                // Usually yes, or find best price. For now return first active.
                                return [$value, $flash_id, $valid_from, $valid_to, $flash_name];
                            }
                        }
                    }
                }
            }
        }

        return [$value, $flash_id, $valid_from, $valid_to, $flash_name];
    }
}
