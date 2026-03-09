<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'valid_from' => 'date',
        'valid_until' => 'date',
        'is_active' => 'boolean',
        'discount_value' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'product_id' => 'array',
        'payment_method_id' => 'array',
        'include_shipping' => 'boolean',
        'include_services' => 'boolean',
    ];

    /**
     * Scope a query to only include active coupons.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->whereDate('valid_from', '<=', now())
                     ->whereDate('valid_until', '>=', now());
    }

    /**
     * Get the product associated with the coupon.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the payment method associated with the coupon.
     */
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
