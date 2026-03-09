<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOptionValue extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    
    protected $casts = [
        'subtract_stock' => 'boolean',
        'price_increment' => 'boolean',
        'weight_increment' => 'boolean',
    ];

    public function productOption()
    {
        return $this->belongsTo(ProductOption::class);
    }
    
    public function optionValue()
    {
        return $this->belongsTo(OptionValue::class);
    }
}
