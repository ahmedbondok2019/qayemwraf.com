<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Link offers to their respective primary categories
        DB::table('offers')->where('id', 1)->update(['category_id' => 1]);
        DB::table('offers')->where('id', 2)->update(['category_id' => 4]);
        DB::table('offers')->where('id', 3)->update(['category_id' => 5]);
        DB::table('offers')->where('id', 4)->update(['category_id' => 6]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
