<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('log_apis')) {
            Schema::create('log_apis', function (Blueprint $table) {
                $table->id();
                $table->text('url')->nullable();
                $table->longText('body')->nullable();
                $table->longText('userFireBaseTokens')->nullable();
                $table->longText('fire_base_result')->nullable();
                $table->softDeletes();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('log_apis');
    }
};
