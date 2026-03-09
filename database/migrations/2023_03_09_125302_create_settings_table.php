<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable();
            $table->string('logo_dark')->nullable();
            $table->string('fav_icon')->nullable();
            $table->String('app_name')->nullable();
            $table->String('app_meta_title')->nullable();
            $table->String('app_meta_desc')->nullable();
            $table->String('address')->nullable();
            $table->String('phone')->nullable();
            $table->String('contact_email')->nullable();
            $table->String('facebook')->nullable();
            $table->String('instagram')->nullable();
            $table->String('twitter')->nullable();
            $table->String('youtube')->nullable();
            $table->String('whatsapp')->nullable();
            $table->String('linkedin')->nullable();
            $table->string('facebook_client_id')->nullable();
            $table->string('facebook_client_secret')->nullable();
            $table->string('facebook_redirect')->nullable();
            $table->string('google_client_id')->nullable();
            $table->string('google_client_secret')->nullable();
            $table->string('google_redirect')->nullable();
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
        Schema::dropIfExists('settings');
    }
}
