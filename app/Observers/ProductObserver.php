<?php

namespace App\Observers;

use App\Http\Controllers\helper\HelperController;
use App\Models\Admin;
use App\Models\Product;
use App\Models\ProductTranslation;
use App\Notifications\AdminNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;

class ProductObserver
{
    public function updating(Product $product)
    {
        // Store original product data before update
        $originalProduct = $product->getOriginal();
        $originalproductTranslation = $product->translation;

        if (isset($originalproductTranslation->title) && isset($originalProduct['price'])) {
            // Compare original and updated values (example for name and description)
            $changes = [
                'title' => ($originalproductTranslation->title !== $product->translation->title) ? "Changed from $originalproductTranslation->title to $product->translation->title" : 'No change',
                'description' => ($originalproductTranslation->description !== $product->translation->description) ? "Changed from $originalproductTranslation->description to $product->translation->description" : 'No change',
                // 'status' => $request->shipping_category == null ? 0 : (isset($Product) ? $product->translation->status : 0),

                'status' => ($originalProduct['status'] !== $product->status) ? 'Changed from '.$originalProduct['status'].'to '.$product->status : 'No change',
                'price' => ($originalProduct['price'] !== $product->price) ? 'Changed from '.$originalProduct['price'].'to '.$product->price : 'No change',
                'max_order' => (intval($originalProduct['max_order']) !== intval($product->max_order)) ? 'Changed from '.$originalProduct['max_order'].'to '.$product->max_order : 'No change',
                'sale_price' => (floatval($originalProduct['sale_price']) !== floatval($product->sale_price)) ? 'Changed from '.$originalProduct['sale_price'].'to '.$product->sale_price : 'No change',
                'cost' => (floatval($originalProduct['cost']) !== floatval($product->cost)) ? 'Changed from '.$originalProduct['cost'].'to '.$product->cost : 'No change',
                'brand_id' => (intval($originalProduct['brand_id']) !== intval($product->brand_id)) ? 'Changed from '.$originalProduct['brand_id'].'to '.$product->brand_id : 'No change',
                'model' => (intval($originalProduct['model']) !== intval($product->model)) ? 'Changed from '.$originalProduct['model'].'to '.$product->model : 'No change',
                'shipping' => (intval($originalProduct['shipping']) !== intval($product->shipping)) ? 'Changed from '.$originalProduct['shipping'].'to '.$product->shipping : 'No change',
                'shipping_category' => (intval($originalProduct['shipping_category']) !== intval($product->shipping_category)) ? 'Changed from '.$originalProduct['shipping_category'].'to '.$product->shipping_category : 'No change',
                'quantity' => (intval($originalProduct['quantity']) !== intval($product->quantity)) ? 'Changed from '.$originalProduct['quantity'].'to '.$product->quantity : 'No change',
                'ignore_quantity' => (boolval($originalProduct['ignore_quantity']) !== boolval($product->ignore_quantity)) ? 'Changed from '.$originalProduct['ignore_quantity'].'to '.$product->ignore_quantity : 'No change',
                'best_seller' => ($originalProduct['best_seller'] !== $product->best_seller) ? 'Changed from '.$originalProduct['best_seller'].'to '.$product->best_seller : 'No change',
                'hot_deals' => ($originalProduct['hot_deals'] !== $product->hot_deals) ? 'Changed from '.$originalProduct['hot_deals'].'to '.$product->hot_deals : 'No change',
                'deal_of_day' => ($originalProduct['deal_of_day'] !== $product->deal_of_day) ? 'Changed from '.$originalProduct['deal_of_day'].'to '.$product->deal_of_day : 'No change',
                'best_seller_start' => ($originalProduct['best_seller_start'] !== $product->best_seller_start) ? 'Changed from '.$originalProduct['best_seller_start'].'to '.$product->best_seller_start : 'No change',
                'best_seller_end' => ($originalProduct['best_seller_end'] !== $product->best_seller_end) ? 'Changed from '.$originalProduct['best_seller_end'].'to '.$product->best_seller_end : 'No change',
                'hot_deals_start' => ($originalProduct['hot_deals_start'] !== $product->hot_deals_start) ? 'Changed from '.$originalProduct['hot_deals_start'].'to '.$product->hot_deals_start : 'No change',
                'hot_deals_end' => ($originalProduct['hot_deals_end'] !== $product->hot_deals_end) ? 'Changed from '.$originalProduct['hot_deals_end'].'to '.$product->hot_deals_end : 'No change',
                'deal_of_day_start' => ($originalProduct['deal_of_day_start'] !== $product->deal_of_day_start) ? 'Changed from '.$originalProduct['deal_of_day_start'].'to '.$product->deal_of_day_start : 'No change',
                'deal_of_day_end' => ($originalProduct['deal_of_day_end'] !== $product->deal_of_day_end) ? 'Changed from '.$originalProduct['deal_of_day_end'].'to '.$product->deal_of_day_end : 'No change',
                'offer_type' => ($originalProduct['offer_type'] !== $product->offer_type) ? 'Changed from '.$originalProduct['offer_type'].'to '.$product->offer_type : 'No change',
                'product_categories' => ($originalProduct['product_categories'] !== $product->product_categories) ? 'Changed from '.$originalProduct['product_categories'].'to '.$product->product_categories : 'No change',
                'product_options' => ($originalProduct['product_options'] !== $product->product_options) ? 'Changed from '.$originalProduct['product_options'].'to '.$product->product_options : 'No change',
                'related_products' => ($originalProduct['related_products'] !== $product->related_products) ? 'Changed from '.$originalProduct['related_products'].'to '.$product->related_products : 'No change',
                'item_code' => ($originalProduct['item_code'] !== $product->item_code) ? 'Changed from '.$originalProduct['item_code'].'to '.$product->item_code : 'No change',
                'barcode' => ($originalProduct['barcode'] !== $product->barcode) ? 'Changed from '.$originalProduct['barcode'].'to '.$product->barcode : 'No change',
                'height' => ($originalProduct['height'] !== $product->height) ? 'Changed from '.$originalProduct['height'].'to '.$product->height : 'No change',
                'width' => ($originalProduct['width'] !== $product->width) ? 'Changed from '.$originalProduct['width'].'to '.$product->width : 'No change',
                'weight' => ($originalProduct['weight'] !== $product->weight) ? 'Changed from '.$originalProduct['weight'].'to '.$product->weight : 'No change',
                'tall' => ($originalProduct['tall'] !== $product->tall) ? 'Changed from '.$originalProduct['tall'].'to '.$product->tall : 'No change',
                'vendor_id' => ($originalProduct['vendor_id'] !== $product->vendor_id) ? 'Changed from '.$originalProduct['vendor_id'].'to '.$product->vendor_id : 'No change',
                'weight_unit' => ($originalProduct['weight_unit'] !== $product->weight_unit) ? 'Changed from '.$originalProduct['weight_unit'].'to '.$product->weight_unit : 'No change',
                'tall_unit' => ($originalProduct['tall_unit'] !== $product->tall_unit) ? 'Changed from '.$originalProduct['tall_unit'].'to '.$product->tall_unit : 'No change',
                'short_url' => ($originalProduct['short_url'] !== $product->short_url) ? 'Changed from '.$originalProduct['short_url'].'to '.$product->short_url : 'No change',
            ];

            // Log changes to a database table, file, or send notification
            $this->logChanges($product->id, $changes);
        }
    }

    private function logChanges($productId, $changes)
    {
        // Implement logic to store changes in a database table, file, or send notification (e.g., email to admin)
        // Log::info("Product $productId updated. Changes: " . json_encode($changes));

        foreach ($changes as $key => $change) {
            if ($change == 'No change') {
                unset($changes[$key]);
            }
        }
        if (! empty($changes)) {
            // تنبيه الادمن
            $admins = HelperController::getAllowedAdmins(null, ['1', '2', '3', '4', '41', '42', '43', '44']);
            Session::put([
                // 'user_notification_title' => $changes,
                'user_notification_title' => ProductTranslation::where('product_id', $productId)->where('lang_id', app()->getLocale())->first()->title,
                'user_notification_image' => Product::find($productId)->translations->primary_image,
                'user_notification_url' => env('APP_URL').'ar/admin-2023/products/edit/'.$productId,
            ]);

            // foreach ($admins as $admin) {
            // Notification::send($Admin, new AdminNotification($admin , $changes));
            Notification::send(Admin::first(), new AdminNotification(Admin::first(), $changes));
            // }
        }
    }
}
