<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::all();

        if ($products->isEmpty()) {
            return;
        }

        $sampleCustomers = [
            ['name' => 'أحمد محمود', 'email' => 'ahmed.m@example.com', 'phone' => '01012345678', 'city' => 'القاهرة', 'address' => 'مدينة نصر - المنطقة الصناعية'],
            ['name' => 'محمد إبراهيم', 'email' => 'mohamed.i@example.com', 'phone' => '01123456789', 'city' => 'الجيزة', 'address' => 'منطقة 6 أكتوبر الصناعية - مخزن رقم 12'],
            ['name' => 'خالد عبد الله', 'email' => 'khaled.a@example.com', 'phone' => '01234567890', 'city' => 'العاشر من رمضان', 'address' => 'العاشر من رمضان - المنطقة B4'],
            ['name' => 'سامح توفيق', 'email' => 'sameh.t@example.com', 'phone' => '01545678901', 'city' => 'الإسكندرية', 'address' => 'برج العرب الجديدة - مجمع المخازن'],
        ];

        foreach ($sampleCustomers as $cust) {
            $order = Order::create([
                'user_id' => null,
                'total' => 0,
                'subtotal' => 0,
                'discount' => 0,
                'tax' => 0,
                'status' => 'completed',
                'payment_method' => 'cod',
                'payment_status' => 'paid',
                'currency' => 'EGP',
                'exchange_rate' => 1,
                'first_name' => $cust['name'],
                'last_name' => '',
                'email' => $cust['email'],
                'phone' => $cust['phone'],
                'address' => $cust['address'],
                'note' => 'طلب تجهيز مخزن شامل الرفوف والقوائم',
            ]);

            $randomProducts = $products->random(rand(1, 3));
            $subtotal = 0;

            foreach ($randomProducts as $prod) {
                $qty = rand(2, 5);
                $price = $prod->price;
                $lineSubtotal = $qty * $price;

                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $prod->id,
                    'quantity' => $qty,
                    'price' => $price,
                    'subtotal' => $lineSubtotal,
                    'rate' => 1,
                ]);

                $subtotal += $lineSubtotal;
            }

            $order->update([
                'subtotal' => $subtotal,
                'total' => $subtotal,
            ]);
        }
    }
}
