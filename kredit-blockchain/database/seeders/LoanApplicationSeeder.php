<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LoanApplication;
use App\Models\User;

// class LoanApplicationSeeder extends Seeder
// {
//     public function run()
//     {
//         $user = User::first();

//         if (!$user) {
//             $this->command->info('Tidak ada user. Jalankan UserSeeder terlebih dahulu.');
//             return;
//         }

//         LoanApplication::create([
//             'user_id' => $user->id,
//             'amount' => 10000000,
//             'duration' => 12,
//             'status' => 'APPROVED',
//         ]);
//     }
// }
