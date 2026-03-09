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
        Schema::dropIfExists('coupons');
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('code')->unique();
            $table->decimal('discount_value', 8, 2);
            $table->string('discount_type')->default('percentage')->comment('percentage, fixed');
            $table->decimal('max_discount', 8, 2)->nullable();
            $table->date('valid_from')->nullable();
            $table->date('valid_until')->nullable();
            $table->integer('usage_limit')->nullable();
            $table->integer('usage_count')->default(0);
            $table->string('usage_limitation')->nullable()->comment('User vs All'); 
            // Or maybe user_id if specific? UI says "Select Usage" -> likely a type
            
            $table->foreignId('payment_method_id')->nullable()->index();
            $table->foreignId('product_id')->nullable()->index();
            
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
