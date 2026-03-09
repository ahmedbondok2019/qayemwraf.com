<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingRuleGovernorate extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function shippingRule()
    {
        return $this->belongsTo(ShippingRule::class);
    }

    public function governorate()
    {
        return $this->belongsTo(Governorate::class);
    }
}
