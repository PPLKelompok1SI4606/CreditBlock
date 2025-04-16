<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LoanApplication;
use App\Models\User;

class LoanApplicationSeeder extends Seeder
{
    public function run()
    {
        // Ambil user pertama
        $user = User::first();

        if (!$user) {
            $this->command->info('Tidak ada user. Jalankan UserSeeder terlebih dahulu.');
            return;
        }

        // Tambahkan loan application dummy
        LoanApplication::create([
            'user_id' => $user->id,
            'amount' => 10000000, // Rp 10.000.000
            'duration' => 12, // 12 bulan
            'status' => 'APPROVED',
        ]);
    }
}