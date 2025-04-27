<?php

namespace App\Http\Controllers;

use App\Models\LoanApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LoanApplicationController extends Controller
{
    public function index()
    {
        $loanApplications = LoanApplication::where('user_id', Auth::id())
            ->where('status', 'APPROVED') // Filter hanya pinjaman yang disetujui
            ->orderBy('created_at', 'desc')
            ->get();
    
        return view('loan-applications.index', compact('loanApplications'));
    }

    public function create()
    {
        return view('loan-applications.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000000',
            'duration' => 'required|integer|min:1|max:60',
            'interest_rate' => 'required|numeric|in:5,10',
            'start_month' => 'required|integer|min:1|max:12',
            'start_year' => 'required|integer|min:2025',
            'end_month' => 'required|integer|min:1|max:12',
            'end_year' => 'required|integer|min:2025',
            'document' => 'required|file|mimes:pdf,jpg,png|max:2048',
        ]);

        // Validate that end date is after start date
        $startDate = \Carbon\Carbon::create($request->start_year, $request->start_month, 1);
        $endDate = \Carbon\Carbon::create($request->end_year, $request->end_month, 1);

        if ($endDate->lessThanOrEqualTo($startDate)) {
            return redirect()->back()
                ->with('error', 'Tanggal selesai pinjaman harus setelah tanggal mulai pinjaman.')
                ->withInput();
        }

        // Validate interest rate based on duration
        $duration = $request->duration;
        $expectedInterestRate = $duration <= 6 ? 5 : 10;
        if ($request->interest_rate != $expectedInterestRate) {
            return redirect()->back()
                ->with('error', 'Suku bunga harus ' . $expectedInterestRate . '% untuk durasi ' . $duration . ' bulan.')
                ->withInput();
        }

        try {
            $documentPath = $request->file('document')->store('documents', 'public');

                // Hitung total pembayaran (pokok + bunga)
            $interestAmount = ($request->amount * $request->interest_rate) / 100; // Bunga
            $totalPayment = $request->amount + $interestAmount; // Total pembayaran

            LoanApplication::create([
                'user_id' => Auth::id(),
                'amount' => $request->amount,
                'duration' => $request->duration,
                'interest_rate' => $request->interest_rate,
                'total_payment' => $totalPayment,
                'start_month' => $request->start_month,
                'start_year' => $request->start_year,
                'end_month' => $request->end_month,
                'end_year' => $request->end_year,
                'document_path' => $documentPath,
                'status' => 'PENDING',
            ]);

            return redirect()->route('dashboard')
                ->with('success', 'Pengajuan pinjaman berhasil dikirim.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menyimpan pengajuan: ' . $e->getMessage());
        }
    }

    public function checkLoanStatus()
    {
        $loanApplication = LoanApplication::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->first();
    
        if ($loanApplication && $loanApplication->status === 'APPROVED') {
            // Hitung total pembayaran yang sudah dilakukan
            $totalPaid = $loanApplication->payments->sum('amount');
    
            // Hitung sisa pembayaran
            $remainingAmount = $loanApplication->total_payment - $totalPaid;
        } else {
            $remainingAmount = 0;
        }
    
        return view('payments.create', compact('loanApplication', 'remainingAmount'));
    }
}
