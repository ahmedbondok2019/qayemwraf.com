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
        Schema::create('product_stock_updates', function (Blueprint $table) {
            $table->id();
            $table->string('filename')->nullable();
            $table->foreignId('admin_id')->constrained('admins')->onDelete('cascade');
            $table->integer('total_rows')->default(0);
            $table->integer('successful_updates')->default(0);
            $table->integer('failed_updates')->default(0);
            $table->json('details')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_stock_updates');
    }
};
