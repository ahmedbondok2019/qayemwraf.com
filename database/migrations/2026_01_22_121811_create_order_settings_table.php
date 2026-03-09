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
        Schema::create('order_settings', function (Blueprint $table) {
            $table->id();
            $table->decimal('free_min_amount', 10, 2)->default(0);
            $table->timestamp('date_from')->nullable();
            $table->timestamp('date_to')->nullable();
            $table->text('categories')->nullable(); // Comma separated IDs
            $table->boolean('multi_shipping_cost')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_settings');
    }
};
