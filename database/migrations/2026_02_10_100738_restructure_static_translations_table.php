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
        Schema::table('static_translations', function (Blueprint $table) {
            $table->dropColumn(['trans_ar', 'trans_en']);
            $table->json('translations')->nullable()->after('key');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('static_translations', function (Blueprint $table) {
            $table->dropColumn('translations');
            $table->text('trans_ar')->nullable();
            $table->text('trans_en')->nullable();
        });
    }
};
