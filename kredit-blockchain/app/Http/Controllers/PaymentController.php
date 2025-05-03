<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoanApplication;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        $payments = Payment::whereHas('loan', function ($query) {
            $query->where('user_id', Auth::id())
                ->whereIn('status', ['APPROVED', 'Belum Lunas', 'Lunas']);
        })->orderBy('payment_date', $request->get('sort', 'desc'))
            ->orderBy('installment_month', 'asc')
          ->get();

        return view('payments.history', compact('payments'));
    }
}
