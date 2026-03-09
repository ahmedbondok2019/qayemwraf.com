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
        if (!Schema::hasTable('flash_sales')) {
            Schema::create('flash_sales', function (Blueprint $table) {
                $table->id();
                $table->dateTime('start_at')->nullable();
                $table->dateTime('end_at')->nullable();
                $table->string('image')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('flash_sale_translations')) {
            Schema::create('flash_sale_translations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('flash_sale_id')->constrained('flash_sales')->onDelete('cascade');
                $table->string('locale')->index();
                $table->string('name');
                $table->unique(['flash_sale_id', 'locale']);
            });
        }

        if (!Schema::hasTable('flash_sale_products')) {
            Schema::create('flash_sale_products', function (Blueprint $table) {
                $table->id();
                $table->foreignId('flash_sale_id')->constrained('flash_sales')->onDelete('cascade');
                $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
                $table->decimal('price', 10, 2)->default(0);
                $table->timestamps();
                
                $table->unique(['flash_sale_id', 'product_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flash_sale_products');
        Schema::dropIfExists('flash_sale_translations');
        Schema::dropIfExists('flash_sales');
    }
};
