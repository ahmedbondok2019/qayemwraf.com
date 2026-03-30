<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashSale extends Model
{
    use HasFactory;
    use \App\Traits\HandleImageStorageTrait;

    protected $guarded = [];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function translations()
    {
        return $this->hasMany(FlashSaleTranslation::class);
    }

    public function translation()
    {
        return $this->hasOne(FlashSaleTranslation::class)->where('locale', app()->getLocale());
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'flash_sale_products')
                    ->withPivot('price')
                    ->withTimestamps();
    }
    
    public function getNameAttribute()
    {
        return $this->translation->name ?? $this->translations->first()->name ?? '';
    }
}
