<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductRelate extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'related_id')->where('status', 1);
    }
}
