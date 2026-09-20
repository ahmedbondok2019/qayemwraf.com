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
            if (! Schema::hasColumn('settings', 'about_tag')) {
                $table->text('about_tag')->nullable();
            }
            if (! Schema::hasColumn('settings', 'about_title')) {
                $table->text('about_title')->nullable();
            }
            if (! Schema::hasColumn('settings', 'about_highlight_text')) {
                $table->text('about_highlight_text')->nullable();
            }
            if (! Schema::hasColumn('settings', 'about_description')) {
                $table->text('about_description')->nullable();
            }
            if (! Schema::hasColumn('settings', 'about_stats')) {
                $table->text('about_stats')->nullable();
            }
            if (! Schema::hasColumn('settings', 'about_features')) {
                $table->text('about_features')->nullable();
            }
            if (! Schema::hasColumn('settings', 'about_image_1')) {
                $table->string('about_image_1')->nullable();
            }
            if (! Schema::hasColumn('settings', 'about_image_1_badge_title')) {
                $table->text('about_image_1_badge_title')->nullable();
            }
            if (! Schema::hasColumn('settings', 'about_image_1_badge_subtitle')) {
                $table->text('about_image_1_badge_subtitle')->nullable();
            }
            if (! Schema::hasColumn('settings', 'about_image_2')) {
                $table->string('about_image_2')->nullable();
            }
            if (! Schema::hasColumn('settings', 'about_image_2_badge')) {
                $table->text('about_image_2_badge')->nullable();
            }
            if (! Schema::hasColumn('settings', 'about_image_3')) {
                $table->string('about_image_3')->nullable();
            }
            if (! Schema::hasColumn('settings', 'about_experience_years')) {
                $table->string('about_experience_years')->nullable();
            }
            if (! Schema::hasColumn('settings', 'about_experience_title')) {
                $table->text('about_experience_title')->nullable();
            }
            if (! Schema::hasColumn('settings', 'about_experience_subtitle')) {
                $table->text('about_experience_subtitle')->nullable();
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
                'about_tag',
                'about_title',
                'about_highlight_text',
                'about_description',
                'about_stats',
                'about_features',
                'about_image_1',
                'about_image_1_badge_title',
                'about_image_1_badge_subtitle',
                'about_image_2',
                'about_image_2_badge',
                'about_image_3',
                'about_experience_years',
                'about_experience_title',
                'about_experience_subtitle',
            ]);
        });
    }
};
