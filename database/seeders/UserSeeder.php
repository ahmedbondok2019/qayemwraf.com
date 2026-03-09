<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory()->count(100)->create();
        User::create([
            'name' => Str::random('10'),
            'email' => 'ahmed@egyptvision.net',
            'phone' => '01007187555',
            'password' => bcrypt('123456789'),
            'status' => 1,
        ]);
    }
}
