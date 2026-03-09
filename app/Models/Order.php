<?php

namespace App\Models;

use App\Http\Controllers\helper\HelperController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function order_details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function order_options()
    {
        return $this->hasMany(OrderOption::class);
    }

    public function order_statuses()
    {
        return $this->hasMany(OrderStatus::class);
    }

    public function order_service_items()
    {
        return $this->hasMany(OrderServiceItem::class);
    }

    public function order_returns()
    {
        return $this->hasMany(OrderReturn::class);
    }

    public function order_product()
    {
        return $this->belongsTo(Product::class, 'id', 'product_id');
    }

    public static function month($month, $year)
    {
        return self::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->sum('total');
    }

    // إصلاح العلاقات مع المحافظة والمدينة
    public function governorate()
    {
        return $this->belongsTo(Governorate::class, 'governorate_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function governorate_rel()
    {
        return $this->belongsTo(Governorate::class, 'governorate_id');
    }

    public function city_rel()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    // إصلاح علاقة المستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // إصلاح دالة حالة الطلب
    public function getOrderStatusAttribute()
    {
        return HelperController::orderStatus($this->status);
    }
}
