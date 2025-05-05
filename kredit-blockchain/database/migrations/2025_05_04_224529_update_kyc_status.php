<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Konversi is_verified ke status_kyc
        DB::table('users')->where('is_verified', true)->update(['status_kyc' => 'approved']);
        DB::table('users')->where('is_verified', false)->where('status_kyc', '!=', 'rejected')->update(['status_kyc' => 'pending']);
        
        // Hapus kolom is_verified
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_verified');
        });
    }

    public function down(): void
    {
        // Tambah kembali kolom is_verified
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_verified')->default(false)->after('email');
        });

        // Kembalikan data dari status_kyc ke is_verified
        DB::table('users')->where('status_kyc', 'approved')->update(['is_verified' => true]);
        DB::table('users')->where('status_kyc', '!=', 'approved')->update(['is_verified' => false]);
    }
};