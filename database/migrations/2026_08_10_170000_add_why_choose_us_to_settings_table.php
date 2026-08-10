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
            $table->text('why_choose_us_title')->nullable();
            $table->text('why_choose_us_subtitle')->nullable();
            $table->text('why_choose_us_items')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['why_choose_us_title', 'why_choose_us_subtitle', 'why_choose_us_items']);
        });
    }
};
