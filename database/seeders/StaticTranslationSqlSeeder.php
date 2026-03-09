<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class StaticTranslationSqlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = public_path('static_translations.sql');
        
        if (File::exists($path)) {
            $sql = File::get($path);
            
            // Disable foreign key checks and drop table to allow the SQL script to re-create it
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::statement('DROP TABLE IF EXISTS static_translations;');
            
            // Execute the raw SQL
            DB::unprepared($sql);
            
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            
            $this->command->info('Static translations SQL seeded successfully!');
        } else {
            $this->command->error('File static_translations.sql not found in public directory.');
        }
    }
}
