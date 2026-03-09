<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrenciesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_default')->default(false);
            $table->boolean('status')->default(true);
            $table->string('image')->nullable();
            $table->string('code')->unique(); // USD, EGP, SAR
            $table->double('exchange_rate', 15, 8)->default(1.0);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('currency_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('currency_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->string('symbol'); // $, £, ج.م
            
            $table->unique(['currency_id', 'locale']);
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
            
            $table->softDeletes();
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
        Schema::dropIfExists('currency_translations');
        Schema::dropIfExists('currencies');
    }
}
