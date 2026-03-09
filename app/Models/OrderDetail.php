<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function order_details_options()
    {
        return $this->hasMany(OrderOption::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function orderOptions()
    {
        return $this->hasMany(OrderOption::class);
    }

    // public function shippingMethod()
    // {
    //     return $this->belongsTo(shippingMethod::class);
    // }

    public function productTranslation()
    {
        return $this->hasOne(ProductTranslation::class, 'product_id', 'product_id')
            ->where('lang_id', app()->getLocale());
    }

    // Attributes for converted prices
    public function getConvertedPriceAttribute()
    {
        return $this->price * $this->rate;
    }

    public function getConvertedDiscountAttribute()
    {
        return $this->discount * $this->rate;
    }

    public function getConvertedSubtotalAttribute()
    {
        return $this->subtotal * $this->rate;
    }
}
