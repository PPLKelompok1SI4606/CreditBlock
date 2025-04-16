<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LoanApplication;
use App\Models\User;

class LoanApplicationSeeder extends Seeder
{
    public function run()
    {
        // Tambahkan user Yohan dan Falah
        $yohan = User::create([
            'name' => 'Yohan',
            'email' => 'yohan@example.com',
            'password' => bcrypt('password'),
            'created_at' => now(),
        ]);

        $falah = User::create([
            'name' => 'Falah',
            'email' => 'falah@example.com',
            'password' => bcrypt('password'),
            'created_at' => now(),
        ]);

        // Tambahkan pengajuan pinjaman untuk Yohan
        LoanApplication::create([
            'user_id' => $yohan->id,
            'amount' => 8000000,
            'duration' => 10,
            'status' => 'menunggu',
            'created_at' => now(),
        ]);

        // Tambahkan pengajuan pinjaman untuk Falah
        LoanApplication::create([
            'user_id' => $falah->id,
            'amount' => 12000000,
            'duration' => 15,
            'status' => 'menunggu',
            'created_at' => now(),
        ]);
    }
}