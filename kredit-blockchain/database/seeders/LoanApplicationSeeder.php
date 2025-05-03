<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LoanApplication;
use App\Models\User;

class LoanApplicationSeeder extends Seeder
{
    public function run()
    {
        $user = User::first();

        if (!$user) {
            $this->command->info('Tidak ada user. Jalankan UserSeeder terlebih dahulu.');
            return;
        }

        // Data dummy untuk grafik
        $loanApplications = [
            [
                'user_id' => $user->id,
                'amount' => 10000000,
                'duration' => 12,
                'interest_rate' => 5,
                'start_month' => 1,
                'start_year' => 2025,
                'end_month' => 12,
                'end_year' => 2025,
                'total_payment' => 10500000, // Pokok + bunga
                'status' => 'APPROVED',
            ],
            [
                'user_id' => $user->id,
                'amount' => 15000000,
                'duration' => 24,
                'interest_rate' => 10,
                'start_month' => 2,
                'start_year' => 2025,
                'end_month' => 1,
                'end_year' => 2027,
                'total_payment' => 16500000, // Pokok + bunga
                'status' => 'APPROVED',
            ],
            [
                'user_id' => $user->id,
                'amount' => 20000000,
                'duration' => 6,
                'interest_rate' => 5,
                'start_month' => 3,
                'start_year' => 2025,
                'end_month' => 8,
                'end_year' => 2025,
                'total_payment' => 21000000, // Pokok + bunga
                'status' => 'APPROVED',
            ],
        ];

        foreach ($loanApplications as $loanApplication) {
            LoanApplication::create($loanApplication);
        }

        $this->command->info('Loan applications seeded successfully.');
    }
}