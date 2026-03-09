<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethodTranslation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
