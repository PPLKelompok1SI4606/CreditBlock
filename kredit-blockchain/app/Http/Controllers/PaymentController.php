<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoanApplication;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function create()
    {
        // Cari pinjaman aktif untuk user saat ini
        $loan = LoanApplication::where('user_id', Auth::id())
            ->whereIn('status', ['APPROVED', 'PENDING', 'Belum Lunas', 'Lunas'])
            ->orderBy('created_at', 'desc')
            ->first();

        Log::info('Loan Query Result:', ['loan' => $loan]);

        // Jika tidak ada pinjaman
        if (!$loan) {
            Log::info('Tidak ada pinjaman untuk user:', ['user_id' => Auth::id()]);
            return view('payments.create', ['loanApplication' => null]);
        }

        Log::info('Status Pinjaman:', ['status' => $loan->status]);

        // Jika status pinjaman adalah PENDING
        if ($loan->status === 'PENDING') {
            Log::info('Pinjaman dengan status PENDING ditemukan:', ['loan' => $loan]);
            return view('payments.create', ['loanApplication' => $loan]);
        }

        // Jika status pinjaman adalah APPROVED atau Belum Lunas
        $paidAmount = $loan->payments()->sum('amount');
        $remainingAmount = $loan->total_payment - $paidAmount;

        return view('payments.create', [
            'loanApplication' => $loan,
            'remainingAmount' => $remainingAmount,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'installment_month' => 'required|integer|min:1',
            'amount' => 'required|numeric|min:1',
        ]);

        $loan = LoanApplication::where('user_id', Auth::id())
            ->whereIn('status', ['APPROVED', 'Belum Lunas'])
            ->first();

        if (!$loan) {
            return redirect()->back()->with('error', 'Tidak ada pinjaman aktif untuk pembayaran.');
        }

        // Validasi bahwa installment_month belum dibayar
        $existingPayment = Payment::where('loan_application_id', $loan->id)
            ->where('installment_month', $request->installment_month)
            ->exists();

        if ($existingPayment) {
            return redirect()->back()->with('error', 'Cicilan untuk bulan ini sudah dibayar.');
        }

        // Hitung total pembayaran yang sudah dilakukan
        $paidAmount = $loan->payments()->sum('amount');
        $remainingAmount = $loan->total_payment - $paidAmount - $request->amount;

        // Tentukan status pembayaran
        $status = $remainingAmount <= 0 ? 'Lunas' : 'Belum Lunas';

        // Jika status pinjaman masih APPROVED, ubah menjadi Belum Lunas
        if ($loan->status === 'APPROVED') {
            $loan->update(['status' => 'Belum Lunas']);
        }

        // Simpan pembayaran baru
        Payment::create([
            'loan_application_id' => $loan->id,
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'payment_date' => now(),
            'status' => $status,
            'installment_month' => $request->input('installment_month'),
        ]);

        // Jika sisa pembayaran 0, update status pinjaman ke Lunas
        if ($remainingAmount <= 0) {
            $loan->update(['status' => 'Lunas']);
        }

        return redirect()->route('payments.history')->with('success', 'Pembayaran berhasil disimpan.');
    }

    public function history(Request $request)
{
    try {
        $payments = Payment::whereHas('loan', function ($query) {
            $query->where('user_id', Auth::id())
                  ->whereIn('status', ['APPROVED', 'Belum Lunas', 'Lunas']);
        })
        ->with(['loan' => function($query) {
            $query->select('id', 'amount', 'total_payment', 'start_month', 'start_year', 'end_month', 'end_year');
        }])
        ->orderBy('payment_date', $request->get('sort', 'desc'))
        ->orderBy('installment_month', 'asc')
        ->get();

        // Calculate payment details
        $paymentDetails = [];
        $cumulativePaid = 0;
        $currentLoanId = null;

        foreach ($payments as $payment) {
            $loan = $payment->loan;
            if ($currentLoanId !== $loan->id) {
                $cumulativePaid = 0;
                $currentLoanId = $loan->id;
            }
            $cumulativePaid += $payment->amount;
            $remainingAmount = $loan->total_payment - $cumulativePaid;
            $status = $remainingAmount <= 0 ? 'LUNAS' : 'Belum Lunas';

            $startMonth = $loan->start_month;
            $startYear = $loan->start_year;
            $currentMonth = ($startMonth + $payment->installment_month - 2) % 12 + 1;
            $currentYear = $startYear + intdiv($startMonth + $payment->installment_month - 2, 12);
            $monthName = \Carbon\Carbon::create()->month($currentMonth)->format('F');

            $paymentDetails[] = [
                'payment' => $payment,
                'monthName' => $monthName,
                'currentYear' => $currentYear,
                'remainingAmount' => $remainingAmount,
                'status' => $status,
            ];
        }

        $summary = [
            'total_paid' => $payments->sum('amount'),
            'total_installments' => $payments->count(),
            'last_payment_date' => $payments->first() ? $payments->first()->payment_date->format('d F Y') : '-',
        ];

        return view('payments.history', compact('paymentDetails', 'summary'));

    } catch (\Exception $e) {
        Log::error('Payment History Error: ' . $e->getMessage());
        return redirect()->back()
            ->with('error', 'Terjadi kesalahan saat mengambil data pembayaran. Silakan coba lagi.');
    }
}
public function exportPdf(Request $request)
{
    try {
        Log::info('Export PDF diakses oleh user:', ['user_id' => Auth::id()]);

        // Get user's payments with loan information
        $payments = Payment::whereHas('loan', function ($query) {
            $query->where('user_id', Auth::id())
                  ->whereIn('status', ['APPROVED', 'Belum Lunas', 'Lunas']);
        })
        ->with(['loan' => function($query) {
            $query->select('id', 'amount', 'total_payment', 'start_month', 'start_year', 'end_month', 'end_year');
        }])
        ->orderBy('payment_date', 'desc')
        ->orderBy('installment_month', 'asc')
        ->get();

        Log::info('Payments for PDF Export:', ['count' => $payments->count(), 'payments' => $payments->toArray()]);

        if ($payments->isEmpty()) {
            return redirect()->route('payments.history')
                ->with('error', 'Tidak ada data pembayaran untuk diekspor.');
        }

        // Calculate summary data
        $summary = [
            'total_paid' => $payments->sum('amount'),
            'total_installments' => $payments->count(),
            'last_payment_date' => $payments->first() ? $payments->first()->payment_date->format('d F Y') : '-',
            'export_date' => Carbon::now()->format('d F Y H:i:s'),
        ];

        // Get user information
        $user = Auth::user();

        // Generate PDF
        $pdf = PDF::loadView('payments.pdf-history', [
            'payments' => $payments,
            'summary' => $summary,
            'user' => $user
        ]);

        // Set PDF options
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultFont' => 'DejaVu Sans', // Gunakan font yang didukung
            'php' => [
                'memory_limit' => '512M',
                'max_execution_time' => 120,
            ]
        ]);

        // Generate filename with date
        $filename = 'riwayat-pembayaran-' . Carbon::now()->format('Y-m-d') . '.pdf';

        return $pdf->download($filename);

    } catch (\Exception $e) {
        Log::error('PDF Export Error: ' . $e->getMessage(), ['stack' => $e->getTraceAsString()]);
        return redirect()->route('payments.history')
            ->with('error', 'Terjadi kesalahan saat mengekspor PDF: ' . $e->getMessage());
    }
}
}
