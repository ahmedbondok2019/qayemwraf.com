<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    protected $casts = [
        'required' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    public function option()
    {
        return $this->belongsTo(Option::class);
    }
    
    public function values()
    {
        return $this->hasMany(ProductOptionValue::class, 'product_option_id');
    }
}
