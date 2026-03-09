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
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('shipping_rule_id')->nullable()->constrained('shipping_rules')->nullOnDelete();
            $table->unsignedBigInteger('product_brand_id')->nullable(); 
            
            $table->string('sku')->nullable();
            $table->string('image')->nullable();
            
            // Pricing & Promo
            $table->decimal('special_price', 10, 2)->nullable();
            $table->date('special_price_start')->nullable();
            $table->date('special_price_end')->nullable();
            
            // Stock
            $table->integer('quantity')->default(0);
            $table->integer('max_order_qty')->nullable();
            $table->boolean('ignore_quantity')->default(false);
            
            // Best Seller
            $table->boolean('is_best_seller')->default(false);
            $table->date('best_seller_start')->nullable();
            $table->date('best_seller_end')->nullable();
            
            // Other
            $table->decimal('weight', 10, 2)->nullable();
            $table->bigInteger('viewed')->default(0);
        });

        Schema::table('product_translations', function (Blueprint $table) {
            $table->string('slug')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
        });

        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('image');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('product_categories', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->primary(['product_id', 'category_id']);
        });

        Schema::create('product_related', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('related_product_id')->constrained('products')->onDelete('cascade');
            $table->primary(['product_id', 'related_product_id']);
        });

        // Product Options Structure
        Schema::create('product_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('option_id')->constrained('options')->onDelete('cascade');
            $table->boolean('required')->default(false);
            $table->timestamps();
        });

        Schema::create('product_option_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_option_id')->constrained('product_options')->onDelete('cascade');
            $table->foreignId('option_value_id')->constrained('option_values')->onDelete('cascade');
            $table->integer('quantity')->default(0);
            $table->boolean('subtract_stock')->default(false);
            $table->boolean('price_increment')->default(true); // true = +, false = -
            $table->decimal('price', 10, 2)->default(0);
            $table->boolean('weight_increment')->default(true); // true = +, false = -
            $table->decimal('weight', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_option_values');
        Schema::dropIfExists('product_options');
        Schema::dropIfExists('product_related');
        Schema::dropIfExists('product_categories');
        Schema::dropIfExists('product_images');
        
        Schema::table('product_translations', function (Blueprint $table) {
            $table->dropColumn(['slug', 'meta_title', 'meta_description']);
        });

        Schema::table('products', function (Blueprint $table) {
             $table->dropColumn([
                'shipping_rule_id', 'product_brand_id', 'sku', 'image',
                'special_price', 'special_price_start', 'special_price_end',
                'quantity', 'max_order_qty', 'ignore_quantity',
                'is_best_seller', 'best_seller_start', 'best_seller_end',
                'weight', 'viewed'
             ]);
        });
    }
};
