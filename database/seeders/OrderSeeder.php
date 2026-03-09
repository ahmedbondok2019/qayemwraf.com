<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Faker\Factory as Faker;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Check if Faker exists (it's a dev dependency)
        if (!class_exists(\Faker\Factory::class)) {
            $this->command->warn('Faker library not found. Skipping OrderSeeder.');
            return;
        }

        $faker = \Faker\Factory::create();
        $products = Product::all();

        if ($products->isEmpty()) {
            return;
        }
// 
        for ($i = 0; $i < 50; $i++) {
            $total = 0;
            
            // Create Order
            $order = Order::create([
                'user_id' => null, // Guest or random user if User model exists
                'total' => 0, // Will update later
                'subtotal' => 0,
                'discount' => 0,
                'tax' => 0,
                'status' => $faker->randomElement(['pending', 'processing', 'completed', 'cancelled']),
                'payment_method' => $faker->randomElement(['cod', 'credit_card', 'paypal']),
                'payment_status' => $faker->randomElement(['pending', 'paid']),
                'currency' => 'EGP',
                'exchange_rate' => 1,
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->email,
                'phone' => $faker->phoneNumber,
                'address' => $faker->address,
                'note' => $faker->sentence,
            ]);

            // Add Order Details
            $randomProducts = $products->random(rand(1, 5));
            $subtotal = 0;

            foreach ($randomProducts as $product) {
                $qty = rand(1, 3);
                $price = $product->price;
                $lineSubtotal = $qty * $price;

                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'price' => $price,
                    'subtotal' => $lineSubtotal,
                    'rate' => 1,
                ]);

                $subtotal += $lineSubtotal;
            }

            // Update Order Totals
            $order->update([
                'subtotal' => $subtotal,
                'total' => $subtotal, // Simple logic, ignoring tax/discount for now
            ]);
        }
    }
}
