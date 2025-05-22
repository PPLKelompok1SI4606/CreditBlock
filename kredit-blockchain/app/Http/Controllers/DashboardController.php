<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;
use App\Models\LoanApplication;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil pinjaman untuk grafik
        $loanApplications = LoanApplication::where('user_id', $user->id)
            ->whereIn('status', ['APPROVED', 'Belum Lunas', 'Lunas'])
            ->whereNotNull('approved_at')
            ->orderBy('approved_at', 'desc')
            ->get();

        // Format data untuk grafik
        $chartData = $loanApplications->map(function ($loan) {
            return [
                'label' => $loan->approved_at->translatedFormat('d M Y'),
                'amount' => $loan->amount,
                'status' => $loan->status,
                'duration' => $loan->duration,
                'end_label' => Carbon::create($loan->end_year, $loan->end_month, 1)->translatedFormat('M Y'),
            ];
        })->toArray();

        // Data untuk "Pinjaman Saya"
        $loans = LoanApplication::where('user_id', $user->id)
            ->where('status', 'APPROVED')
            ->get();
        $totalAmount = $loans->sum('amount');
        $totalPaid = $loans->sum(function ($loan) {
            return $loan->payments()->sum('amount');
        });
        $remainingAmount = $totalAmount - $totalPaid;
        $monthlyInstallment = $loans->sum(function ($loan) {
            return $loan->amount / $loan->duration;
        });
        $nextDueDate = $loans->isNotEmpty() ? now()->addMonth()->format('d M Y') : '-';
        $loanStatus = $loans->isNotEmpty() ? 'Aktif' : 'Tidak Aktif';
        $loanStatusStyle = $loans->isNotEmpty() ? 'bg-blue-100 text-blue-700 animate-pulse' : 'bg-gray-100 text-gray-700';

        // Data untuk "Pengajuan Pinjaman"
        $latestLoan = LoanApplication::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->first();
        $latestLoanData = $latestLoan ? [
            'remainingAmount' => $latestLoan->status === 'APPROVED' ? ($latestLoan->amount - $latestLoan->payments()->sum('amount')) : $latestLoan->amount,
            'monthlyInstallment' => $latestLoan->status === 'APPROVED' ? ($latestLoan->amount / $latestLoan->duration) : 0,
            'nextDueDate' => $latestLoan->status === 'APPROVED' ? now()->addMonth()->format('d M Y') : '-',
            'duration' => $latestLoan->duration,
            'status' => $latestLoan->status,
        ] : null;

        // Ambil riwayat pembayaran
        $payments = Payment::whereHas('loan', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->orderBy('payment_date', 'desc')->get();

        return view('dashboard', compact(
            'chartData',
            'payments',
            'loans',
            'totalAmount',
            'remainingAmount',
            'monthlyInstallment',
            'nextDueDate',
            'loanStatus',
            'loanStatusStyle',
            'latestLoan',
            'latestLoanData'
        ));
    }

    /* public function index()
    {
        return view('dashboard');
    } */
}
