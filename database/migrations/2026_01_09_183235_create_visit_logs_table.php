<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('visit_logs', function (Blueprint $table) {
            $table->bigIncrements('id');

            // Visitor identity
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('ip', 45)->nullable()->index(); // supports IPv6
            $table->string('session_id', 100)->nullable()->index();

            // Request info
            $table->string('method', 10)->nullable();
            $table->text('url')->nullable();
            $table->text('referer')->nullable();
            $table->text('user_agent')->nullable();

            // Geo/IP-API fields
            $table->string('status', 20)->nullable()->index();
            $table->string('country', 100)->nullable()->index();
            $table->string('country_code', 10)->nullable()->index();
            $table->string('region', 20)->nullable();
            $table->string('region_name', 100)->nullable();
            $table->string('city', 100)->nullable()->index();
            $table->string('zip', 30)->nullable();

            $table->decimal('lat', 10, 6)->nullable();
            $table->decimal('lon', 10, 6)->nullable();

            $table->string('timezone', 60)->nullable();
            $table->string('isp', 191)->nullable();
            $table->string('org', 191)->nullable();
            $table->string('as', 191)->nullable();

            $table->string('query', 45)->nullable(); // ip-api query field

            // Store full response for future analytics
            $table->json('raw')->nullable();

            $table->timestamps();

            // Optional FK (لو تحب تربطه بجدول users)
            // $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visit_logs');
    }
};
