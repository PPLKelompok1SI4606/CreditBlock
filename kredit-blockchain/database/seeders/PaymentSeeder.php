<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\User;
use App\Models\LoanApplication;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    public function run()
    {
        // Create or get the borrower user
        $user = User::firstOrCreate(
            ['email' => 'borrower@example.com'],
            [
                'name' => 'Loan Borrower',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        // Create or get the loan application
        $loan = LoanApplication::firstOrCreate(
            ['user_id' => $user->id],
            [
                'amount' => 10000000,
                'duration' => 12,
                'status' => 'APPROVED',
            ]
        );

        // Create payments manually
        $payments = [
            [
                'user_id' => $user->id,
                'loan_application_id' => $loan->id, // Gunakan loan_application_id
                'amount' => 1000000,
                'payment_date' => Carbon::now()->subDays(30),
                'status' => 'Lunas',
            ],
            [
                'user_id' => $user->id,
                'loan_application_id' => $loan->id, // Gunakan loan_application_id
                'amount' => 1000000,
                'payment_date' => Carbon::now()->subDays(20),
                'status' => 'Lunas',
            ],
        ];

        foreach ($payments as $payment) {
            Payment::create($payment);
        }

        $this->command->info('Created payments for loan ID: ' . $loan->id);
    }
}