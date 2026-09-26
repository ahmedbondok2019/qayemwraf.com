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
            if (! Schema::hasColumn('settings', 'showroom_tag')) {
                $table->text('showroom_tag')->nullable();
            }
            if (! Schema::hasColumn('settings', 'showroom_title')) {
                $table->text('showroom_title')->nullable();
            }
            if (! Schema::hasColumn('settings', 'showroom_address')) {
                $table->text('showroom_address')->nullable();
            }
            if (! Schema::hasColumn('settings', 'showroom_working_hours')) {
                $table->text('showroom_working_hours')->nullable();
            }
            if (! Schema::hasColumn('settings', 'showroom_features')) {
                $table->text('showroom_features')->nullable();
            }
            if (! Schema::hasColumn('settings', 'showroom_map_button_text')) {
                $table->text('showroom_map_button_text')->nullable();
            }
            if (! Schema::hasColumn('settings', 'showroom_map_url')) {
                $table->text('showroom_map_url')->nullable();
            }
            if (! Schema::hasColumn('settings', 'showroom_map_iframe')) {
                $table->text('showroom_map_iframe')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'showroom_tag',
                'showroom_title',
                'showroom_address',
                'showroom_working_hours',
                'showroom_features',
                'showroom_map_button_text',
                'showroom_map_url',
                'showroom_map_iframe',
            ]);
        });
    }
};
