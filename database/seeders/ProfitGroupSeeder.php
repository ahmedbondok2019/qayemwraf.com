<?php

namespace Database\Seeders;

use App\Models\ProfitGroup;
use Illuminate\Database\Seeder;

class ProfitGroupSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        ProfitGroup::create([
            'title' => 'distributor',
            'value' => 2,
            'type' => 1,
        ]);
        ProfitGroup::create([
            'title' => 'large business',
            'value' => 5,
            'type' => 1,
        ]);
        ProfitGroup::create([
            'title' => 'small business',
            'value' => 7,
            'type' => 1,
        ]);
    }
}
