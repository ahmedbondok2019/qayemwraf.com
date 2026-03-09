<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Admin::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'admin',
                'password' => bcrypt('123456789'),
                'permission_group' => 1,
                'status' => 1,
            ]
        );

        // Vendor::create([
        //     'name' => 'admin',
        //     'phone' => '',
        //     'address' => '',
        //     'website' => '',
        //     'category' => '',
        //     'email' => 'admin@admin.com',
        //     'password' => bcrypt('123456789'),
        //     'status' => 1,
        //     'profit_group' => 1,
        //     'bank_name' => 'البنك الاهلى المصرى',
        //     'bank_iban' => Str::random(15),
        // ]);
        // \App\Models\Admin::factory()->count(100)->create();
    }
}
