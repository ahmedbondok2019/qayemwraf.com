<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function options()
    {
        return $this->hasMany(CartOption::class);
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id')->where('status', 1);
    }
}
