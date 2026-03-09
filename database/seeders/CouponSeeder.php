<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Coupon;
use Carbon\Carbon;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some random product IDs
        $productIds = Product::inRandomOrder()->limit(10)->pluck('id');

        $coupons = [
            [
                'title' => 'Welcome Discount',
                'code' => 'WELCOME10',
                'discount_value' => 10,
                'discount_type' => 'percentage',
                'max_discount' => 50,
                'valid_from' => Carbon::now(),
                'valid_until' => Carbon::now()->addMonths(6),
                'usage_limit' => 100,
                'usage_count' => 0,
                'is_active' => true,
                'product_id' => $productIds->isNotEmpty() ? $productIds->random() : null,
            ],
            [
                'title' => 'Ramadan Special',
                'code' => 'RAMADAN50',
                'discount_value' => 50,
                'discount_type' => 'fixed',
                'max_discount' => null,
                'valid_from' => Carbon::now()->subDays(10),
                'valid_until' => Carbon::now()->addDays(20),
                'usage_limit' => 500,
                'usage_count' => 12,
                'is_active' => true,
                'product_id' => $productIds->isNotEmpty() ? $productIds->random() : null,
            ],
            [
                'title' => 'Flash Sale',
                'code' => 'FLASH20',
                'discount_value' => 20,
                'discount_type' => 'percentage',
                'max_discount' => 100,
                'valid_from' => Carbon::now(),
                'valid_until' => Carbon::now()->addDays(2),
                'usage_limit' => 50,
                'usage_count' => 50, // Fully used/expired
                'is_active' => false,
                'product_id' => null, // Global coupon
            ],
            [
                'title' => 'Old Expired',
                'code' => 'OLD2020',
                'discount_value' => 5,
                'discount_type' => 'percentage',
                'max_discount' => 20,
                'valid_from' => Carbon::now()->subYear(),
                'valid_until' => Carbon::now()->subMonth(),
                'usage_limit' => 1000,
                'usage_count' => 100,
                'is_active' => false,
                'product_id' => null,
            ],
        ];

        foreach ($coupons as $coupon) {
            Coupon::updateOrCreate(['code' => $coupon['code']], $coupon);
        }
    }
}
