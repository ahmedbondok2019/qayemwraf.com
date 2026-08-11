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
            if (!Schema::hasColumn('settings', 'catalog_title')) {
                $table->text('catalog_title')->nullable();
            }
            if (!Schema::hasColumn('settings', 'catalog_description')) {
                $table->text('catalog_description')->nullable();
            }
            if (!Schema::hasColumn('settings', 'catalog_pdf')) {
                $table->text('catalog_pdf')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['catalog_title', 'catalog_description', 'catalog_pdf']);
        });
    }
};
