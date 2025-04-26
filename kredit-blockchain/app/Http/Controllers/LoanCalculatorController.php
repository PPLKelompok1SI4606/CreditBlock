<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class LoanCalculatorController extends Controller
{
    public function calculate(Request $request)
    {
        $validated = $request->validate([
            'loan_amount' => 'required|numeric|min:1000000|max:100000000',
            'loan_duration' => 'required|integer|min:1',
            'start_month' => 'required|integer|between:1,12',
            'start_year' => 'required|integer|min:2025',
            'end_month' => 'required|integer|between:1,12',
            'end_year' => 'required|integer|min:2025',
        ]);

        $loanAmount = $validated['loan_amount'];
        $loanDuration = $validated['loan_duration'];
        $startDate = Carbon::create($validated['start_year'], $validated['start_month'], 1);
        $endDate = Carbon::create($validated['end_year'], $validated['end_month'], 1);

        // Validate end date aligns with start date + duration
        $expectedEndDate = $startDate->copy()->addMonths($loanDuration - 1);
        if ($endDate->format('Y-m') !== $expectedEndDate->format('Y-m')) {
            return response()->json(['error' => 'Tanggal selesai tidak sesuai dengan lama pinjaman.'], 422);
        }

        // Determine interest rate based on duration
        $interestRate = $loanDuration <= 6 ? 0.05 : 0.10; // 5% for 1-6 months, 10% for >6 months

        // Calculate monthly payments
        $monthlyPrincipal = $loanAmount / $loanDuration;
        $totalInterest = $loanAmount * $interestRate;
        $monthlyInterest = $totalInterest / $loanDuration;
        $monthlyPayment = $monthlyPrincipal + $monthlyInterest;

        // Generate amortization schedule
        $schedule = [];
        $remainingBalance = $loanAmount;

        for ($i = 1; $i <= $loanDuration; $i++) {
            $periodDate = $startDate->copy()->addMonths($i - 1);
            $schedule[] = [
                'period' => $periodDate->format('M Y'),
                'interest_payment' => round($monthlyInterest),
                'principal_payment' => round($monthlyPrincipal),
                'total_payment' => round($monthlyPayment),
                'remaining_balance' => round($remainingBalance - $monthlyPrincipal),
            ];
            $remainingBalance -= $monthlyPrincipal;
        }

        return response()->json([
            'monthly_principal' => round($monthlyPrincipal),
            'monthly_interest' => round($monthlyInterest),
            'total_monthly_payment' => round($monthlyPayment),
            'schedule' => $schedule,
            'interest_rate' => $interestRate * 100, // Return as percentage
        ]);
    }
}