<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ProductTranslation extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];

    public function parent_product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
