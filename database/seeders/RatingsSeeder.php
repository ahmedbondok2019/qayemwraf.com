<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Rating;
use App\Models\User;

class RatingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userId = 9;
        
        $user = User::find($userId);
        if (!$user) {
            $user = User::create([
                'id' => $userId,
                'name' => 'Reviewer User',
                'email' => 'reviewer9@example.com',
                'password' => bcrypt('password'), // You might want to set a known password
                'phone' => '01000000009',
            ]);
            $this->command->info("Created user with ID $userId");
        }

        $products = Product::all();

        $comments = [
            'Great product!',
            'Good value for money.',
            'Okay, but could be better.',
            'Not satisfied with the quality.',
            'Excellent!',
            'Fast shipping and good packaging.',
            'Average product.',
            'Highly recommended!',
            'Will buy again.',
            'Terrible experience.'
        ];

        foreach ($products as $product) {
            // 70% chance to rate a product
            if (rand(1, 100) > 30) {
                Rating::updateOrCreate(
                    [
                        'user_id' => $userId,
                        'product_id' => $product->id
                    ],
                    [
                        'rating' => rand(1, 5),
                        'comment' => $comments[array_rand($comments)],
                        'status' => 1, // Approved
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}
