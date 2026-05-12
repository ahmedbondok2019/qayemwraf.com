<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    use \App\Traits\HandleImageStorageTrait;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
        'ignore_quantity' => 'boolean',
        'is_best_seller' => 'boolean',
        'is_gift' => 'boolean',
        'show_on_home' => 'boolean',
        'special_price_start' => 'date',
        'special_price_end' => 'date',
        'best_seller_start' => 'date',
        'best_seller_end' => 'date',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function brand()
    {
        return $this->belongsTo(ProductBrand::class, 'product_brand_id');
    }
    
    public function shippingRule()
    {
        return $this->belongsTo(ShippingRule::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function translation()
    {
        return $this->hasOne(ProductTranslation::class)->where('locale', app()->getLocale());
    }

    public function translations()
    {
        return $this->hasMany(ProductTranslation::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }

    // This relates to the ProductOptions pivot which links Product -> Option (e.g. Color)
    public function productOptions()
    {
        return $this->hasMany(ProductOption::class);
    }
    
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
    
    public function relatedProducts()
    {
        return $this->belongsToMany(Product::class, 'product_related', 'product_id', 'related_product_id');
    }

    public function flashSales()
    {
        return $this->belongsToMany(FlashSale::class, 'flash_sale_products')
                    ->withPivot('price')
                    ->withTimestamps();
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
    
    public function getNameAttribute()
    {
        return $this->translation->name ?? $this->translations->first()->name ?? '';
    }

    public function getConvertedPriceAttribute()
    {
        $rate = session('exchange_rate', 1);
        if ($rate == 0) $rate = 1; // Avoid division by zero
        return $this->price / $rate;
    }

    public function getCurrencySymbolAttribute()
    {
        return session('currency_symbol', 'ج.م');
    }

    public function averageRating()
    {
        return $this->ratings()->where('status', 1)->avg('rating') ?: 0;
    }

    public function ratingCount()
    {
        return $this->ratings()->where('status', 1)->count();
    }

    public function getHasSpecialPriceAttribute()
    {
        if (!$this->special_price || $this->special_price <= 0) return false;
        
        $now = now();
        $start = $this->special_price_start;
        $end = $this->special_price_end;
        
        return (!$start || $start <= $now) && (!$end || $end >= $now);
    }

    public function getCurrentPriceAttribute()
    {
        return $this->has_special_price ? $this->special_price : $this->price;
    }
}
