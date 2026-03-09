<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->decimal('dollar_rate', 8, 2)->default(50.00)->nullable(); // Example default
            $table->decimal('saudi_riyal_rate', 8, 2)->default(13.00)->nullable(); // Example default
            $table->decimal('egypt_rate', 8, 2)->default(1.00)->nullable(); // Example default
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['dollar_rate', 'saudi_riyal_rate']);
        });
    }
};
