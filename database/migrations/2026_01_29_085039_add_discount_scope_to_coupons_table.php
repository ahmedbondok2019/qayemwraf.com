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
        Schema::table('coupons', function (Blueprint $撥) {
            $撥->boolean('include_shipping')->default(false)->after('discount_type');
            $撥->boolean('include_services')->default(false)->after('include_shipping');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $撥) {
            $撥->dropColumn(['include_shipping', 'include_services']);
        });
    }
};
