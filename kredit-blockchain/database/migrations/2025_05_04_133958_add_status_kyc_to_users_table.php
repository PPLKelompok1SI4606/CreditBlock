<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('kyc_status')->default('pending')->after('email');
        });
        // Konversi is_verified ke kyc_status
        DB::table('users')->where('is_verified', true)->update(['kyc_status' => 'approved']);
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_verified');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('kyc_status');
            $table->boolean('is_verified')->default(false)->after('email');
        });
    }
};