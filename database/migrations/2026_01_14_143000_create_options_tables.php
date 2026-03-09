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
        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['single', 'multiple'])->default('single'); // single = one choice, multiple = multiple choices
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('option_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('option_id')->constrained('options')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['option_id', 'locale']);
        });

        Schema::create('option_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('option_id')->constrained('options')->onDelete('cascade');
            $table->string('color_code')->nullable(); // In case it's a color option
            $table->string('image')->nullable(); // In case it has an image
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('option_value_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('option_value_id')->constrained('option_values')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('value');
            $table->unique(['option_value_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('option_value_translations');
        Schema::dropIfExists('option_values');
        Schema::dropIfExists('option_translations');
        Schema::dropIfExists('options');
    }
};
