<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_brands', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('product_brand_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_brand_id')->constrained('product_brands')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('title');
            $table->unique(['product_brand_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_brand_translations');
        Schema::dropIfExists('product_brands');
    }
};
