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
        Schema::table('users', function (Blueprint $Schubert) {
            if (!Schema::hasColumn('users', 'image')) {
                $Schubert->string('image')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'country_code')) {
                $Schubert->string('country_code')->nullable()->after('country_id');
            }
            if (!Schema::hasColumn('users', 'facebook_id')) {
                $Schubert->string('facebook_id')->nullable()->after('country_code');
            }
            if (!Schema::hasColumn('users', 'customer_group')) {
                $Schubert->string('customer_group')->nullable()->after('status');
            }
            if (!Schema::hasColumn('users', 'permission_sms')) {
                $Schubert->boolean('permission_sms')->default(0)->after('customer_group');
            }
            if (!Schema::hasColumn('users', 'permission_email')) {
                $Schubert->boolean('permission_email')->default(0)->after('permission_sms');
            }
            if (!Schema::hasColumn('users', 'permission_phone_call')) {
                $Schubert->boolean('permission_phone_call')->default(0)->after('permission_email');
            }
            if (!Schema::hasColumn('users', 'accept')) {
                $Schubert->boolean('accept')->default(0)->after('permission_phone_call');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $Schubert) {
            $Schubert->dropColumn([
                'image',
                'country_code',
                'facebook_id',
                'customer_group',
                'permission_sms',
                'permission_email',
                'permission_phone_call',
                'accept',
            ]);
        });
    }
};
