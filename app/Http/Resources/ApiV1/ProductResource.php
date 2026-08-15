<?php

namespace App\Http\Resources\ApiV1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Services\OrderService;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        [$flashPrice, $flashId] = OrderService::getFlashSaleValue($this->id);
        
        return [
            'id' => $this->id,
            'name' => $this->translation->name ?? ($this->translations->first()->name ?? ''),
            'description' => $this->translation->description ?? ($this->translations->first()->description ?? ''),
            'slug' => $this->slug,
            'meta_title' => $this->translation->meta_title ?? ($this->translations->first()->meta_title ?? ''),
            'meta_description' => $this->translation->meta_description ?? ($this->translations->first()->meta_description ?? ''),
            'sku' => $this->sku,
            'price' => (float)$this->price,
            'formatted_price' => format_price($this->price),
            'special_price' => (float)$this->special_price,
            'formatted_special_price' => $this->special_price ? format_price($this->special_price) : null,
            'special_price_start' => $this->special_price_start ? $this->special_price_start->format('Y-m-d') : null,
            'special_price_end' => $this->special_price_end ? $this->special_price_end->format('Y-m-d') : null,
            'final_price' => (float)($flashPrice > 0 ? $flashPrice : ($this->special_price ?: $this->price)),
            'formatted_final_price' => format_price($flashPrice > 0 ? $flashPrice : ($this->special_price ?: $this->price)),
            'currency' => [
                'code' => config('app.currency_code'),
                'symbol' => config('app.currency_symbol'),
                'exchange_rate' => config('app.exchange_rate'),
            ],
            'image' => $this->image ? asset($this->image) : null,
            'gallery' => $this->images->map(function($img) {
                return [
                    'id' => $img->id,
                    'image' => asset($img->image),
                    'sort_order' => (int)$img->sort_order,
                ];
            }),
            'categories' => CategoryResource::collection($this->relationLoaded('categories') ? $this->categories : collect([])),
            'options' => ProductOptionResource::collection($this->relationLoaded('productOptions') ? $this->productOptions : collect([])),
            'quantity' => (int)$this->quantity,
            'max_order_qty' => $this->max_order_qty ? (int)$this->max_order_qty : null,
            'ignore_quantity' => (bool)$this->ignore_quantity,
            'is_best_seller' => (bool)$this->is_best_seller,
            'best_seller_start' => $this->best_seller_start ? $this->best_seller_start->format('Y-m-d') : null,
            'best_seller_end' => $this->best_seller_end ? $this->best_seller_end->format('Y-m-d') : null,
            'weight' => (float)$this->weight,
            'viewed' => (int)$this->viewed,
            'shipping_rule_id' => $this->shipping_rule_id,
            'product_brand_id' => $this->product_brand_id,
            'brand' => $this->brand ? [
                'id' => $this->brand->id,
                'name' => $this->brand->translation->title ?? ($this->brand->translations->first()->title ?? ''), // Brands use title for name
            ] : null,
            'has_flash_sale' => $flashPrice > 0,
            'flash_sale_price' => $flashPrice > 0 ? (float)$flashPrice : null,
            // Legacy fields for Flutter
            'primary_image' => $this->image ? asset($this->image) : null,
            'title' => $this->translation->name ?? ($this->translations->first()->name ?? ''),
            'category_id' => $this->product_category_id ?? ($this->categories->first()->id ?? null),
            'category' => $this->categories->first()->translation->title ?? ($this->categories->first()->translations->first()->title ?? ''),
            'store_name' => 'Mushaf Home',
            'rating' => (float)($this->ratings()->avg('rating') ?? 0),
            'rate_count' => (int)$this->ratings()->count(),
            'sale_price' => (float)($flashPrice > 0 ? $flashPrice : ($this->special_price ?: $this->price)),
            'discount_percentage' => $this->price > 0 ? round((($this->price - ($this->special_price ?: $this->price)) / $this->price) * 100) : 0,
            'item_code' => $this->sku,
            // 'brand' => $this->brand ? ($this->brand->translation->title ?? ($this->brand->translations->first()->title ?? '')) : '',
            'images' => $this->relationLoaded('images') ? $this->images->map(function($img) {
                return ['image' => asset($img->image)];
            }) : [],
            'isFavorite' => false,
            'countFavorite' => 0,
            'countOrder' => (int)($this->orders_count ?? 0),
            'product_link' => frontend_site_url(url(app()->getLocale() . '/products/' . ($this->translation->slug ?? $this->slug ?? $this->id))),
            'product_rates' => $this->ratings()->with('user')->get()->map(function($rate) {
                return [
                    'id' => $rate->id,
                    'user_name' => $rate->user->name ?? 'Guest',
                    'rating' => (int)$rate->rating,
                    'comment' => $rate->comment,
                    'created_at' => $rate->created_at->diffForHumans(),
                ];
            }),
            'deal_of_day_end' => null,
            'related_products' => ProductResource::collection($this->whenLoaded('relatedProducts')),
        ];
    }
}
