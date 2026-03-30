<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;
    use \App\Traits\HandleImageStorageTrait;

    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
