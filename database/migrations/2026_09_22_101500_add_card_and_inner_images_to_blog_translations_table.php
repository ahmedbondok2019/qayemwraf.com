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
        Schema::table('blog_translations', function (Blueprint $table) {
            if (! Schema::hasColumn('blog_translations', 'card_image')) {
                $table->string('card_image')->nullable()->after('image');
            }
            if (! Schema::hasColumn('blog_translations', 'inner_image')) {
                $table->string('inner_image')->nullable()->after('card_image');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blog_translations', function (Blueprint $table) {
            if (Schema::hasColumn('blog_translations', 'inner_image')) {
                $table->dropColumn('inner_image');
            }
            if (Schema::hasColumn('blog_translations', 'card_image')) {
                $table->dropColumn('card_image');
            }
        });
    }
};
