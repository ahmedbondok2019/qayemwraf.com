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
        Schema::create('shipping_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->constrained('countries')->onDelete('cascade');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('shipping_rule_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipping_rule_id')->constrained('shipping_rules')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['shipping_rule_id', 'locale']);
        });

        Schema::create('shipping_rule_governorates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipping_rule_id')->constrained('shipping_rules')->onDelete('cascade');
            $table->foreignId('governorate_id')->constrained('governorates')->onDelete('cascade');
            $table->decimal('rate', 10, 2)->default(0);
            $table->timestamps();
            
            $table->unique(['shipping_rule_id', 'governorate_id'], 'sh_rule_gov_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipping_rule_governorates');
        Schema::dropIfExists('shipping_rule_translations');
        Schema::dropIfExists('shipping_rules');
    }
};
