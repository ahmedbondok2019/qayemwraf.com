<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBrandTranslation extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false; // Translations usually don't need timestamps

    public function productBrand()
    {
        return $this->belongsTo(ProductBrand::class);
    }
}
