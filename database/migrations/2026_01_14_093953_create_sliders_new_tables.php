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
        Schema::dropIfExists('slider_translations');
        Schema::dropIfExists('sliders');

        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->index(); // Linked to sections/categories as requested
            $table->string('image')->nullable();
            $table->string('link')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('slider_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('slider_id')->constrained('sliders')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('button_text')->nullable();
            
            $table->unique(['slider_id', 'locale']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slider_translations');
        Schema::dropIfExists('sliders');
    }
};
