<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStockUpdate extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
        'admin_id',
        'total_rows',
        'successful_updates',
        'failed_updates',
        'details',
    ];

    protected $casts = [
        'details' => 'array',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
