<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->decimal('min_order_for_gift', 8, 2)->nullable()->after('linkedin');
            $table->integer('max_gift_items')->nullable()->after('min_order_for_gift');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('min_order_for_gift');
            $table->dropColumn('max_gift_items');
        });
    }
};
