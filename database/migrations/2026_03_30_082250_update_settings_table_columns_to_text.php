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
            $table->text('app_name')->nullable()->change();
            $table->text('app_meta_title')->nullable()->change();
            $table->text('app_meta_desc')->nullable()->change();
            $table->text('address')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('app_name')->nullable()->change();
            $table->string('app_meta_title')->nullable()->change();
            $table->string('app_meta_desc')->nullable()->change();
            $table->string('address')->nullable()->change();
        });
    }
};
