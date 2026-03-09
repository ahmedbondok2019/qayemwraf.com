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
        Schema::create('order_services', function (Blueprint $table) {
            $table->id();

            $table->string('name');      // Gift Wrapping
            $table->string('name_ar');   // تغليف هدايا

            $table->decimal('price', 10, 2); // سعر الخدمة

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });

        Schema::create('order_service_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('order_service_id')
                  ->constrained('order_services')
                  ->cascadeOnDelete();

            // السعر وقت الطلب (مهم جدًا)
            $table->decimal('price', 10, 2);

            // رسالة كارت الإهداء (اختياري)
            $table->text('gift_message')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_service_items');
        Schema::dropIfExists('order_services');
    }
};
