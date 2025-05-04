<?php

namespace App\Http\Controllers;

use App\Models\LoanApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class LoanApplicationController extends Controller
{
    public function index()
    {
        $loanApplications = LoanApplication::where('user_id', Auth::id())
            ->whereIn('status', ['APPROVED', 'Belum Lunas', 'Lunas'])
            ->orderBy('start_year', 'desc')
            ->orderBy('start_month', 'desc')
            ->get();

        // Siapkan data untuk grafik
        $chartData = $loanApplications->map(function ($loan) {
            return [
                'label' => \Carbon\Carbon::create($loan->start_year, $loan->start_month, 1)->translatedFormat('F Y'),
                'amount' => (float) $loan->amount,
                'status' => (string) $loan->status,
                'duration' => (int) $loan->duration,
                'end_label' => \Carbon\Carbon::create($loan->end_year, $loan->end_month, 1)->translatedFormat('F Y'),
            ];
        })->values()->toArray();

        Log::info('Chart data for user ' . Auth::id() . ': ' . json_encode($chartData));

        return view('dashboard', compact('loanApplications', 'chartData')); // Asumsi grafik ada di dashboard
    }

    public function create()
    {
        // Check if user has an existing unpaid loan
        $hasUnpaidLoan = LoanApplication::where('user_id', Auth::id())
            ->whereIn('status', ['PENDING', 'APPROVED', 'Belum Lunas'])
            ->exists();

        return view('loan-applications.create', compact('hasUnpaidLoan'));
    }

    public function store(Request $request)
    {
        // Check again to prevent race conditions
        $existingLoan = LoanApplication::where('user_id', Auth::id())
            ->whereIn('status', ['PENDING', 'APPROVED', 'Belum Lunas'])
            ->first();

        if ($existingLoan) {
            return redirect()->route('dashboard')
                ->with('error', 'Anda tidak dapat mengajukan pinjaman baru karena masih memiliki pinjaman yang belum lunas atau sedang diproses.');
        }

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

        $remainingAmount = 0;

        if ($loanApplication && in_array($loanApplication->status, ['APPROVED', 'Belum Lunas'])) {
            // Hitung total pembayaran yang sudah dilakukan
            $totalPaid = $loanApplication->payments->sum('amount');

            // Hitung sisa pembayaran
            $remainingAmount = $loanApplication->total_payment - $totalPaid;

            // Update status to Lunas if fully paid
            if ($remainingAmount <= 0 && $loanApplication->status !== 'Lunas') {
                $loanApplication->update(['status' => 'Lunas']);
            }
        }

        return view('payments.create', compact('loanApplication', 'remainingAmount'));
    }

    public function getLoanHistoryChartData()
    {
        $data = LoanApplication::where('user_id', Auth::id())
            ->whereIn('status', ['APPROVED', 'Belum Lunas', 'Lunas'])
            ->orderBy('start_year', 'asc')
            ->orderBy('start_month', 'asc')
            ->get()
            ->map(function ($item) {
                return [
                    'label' => \Carbon\Carbon::create($item->start_year, $item->start_month, 1)->translatedFormat('F Y'),
                    'amount' => (float) $item->amount,
                    'status' => (string) $item->status,
                    'duration' => (int) $item->duration,
                    'end_label' => \Carbon\Carbon::create($item->end_year, $item->end_month, 1)->translatedFormat('F Y'),
                ];
            })->values()->toArray();

        return response()->json($data);
    }
}
