<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\LoanApplication;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function create()
    {
        $loan = LoanApplication::where('user_id', Auth::id())->where('status', 'Aktif')->first();
        if (!$loan) {
            return redirect()->route('dashboard')->with('error', 'Tidak ada pinjaman aktif.');
        }
        $paidAmount = $loan->payments()->sum('amount');
        $remainingAmount = $loan->amount - $paidAmount;
        return view('payment.create', compact('remainingAmount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'payment_date' => 'required|date',
        ]);

        $loan = LoanApplication::where('user_id', Auth::id())->where('status', 'Aktif')->first();
        if (!$loan) {
            return redirect()->route('dashboard')->with('error', 'Tidak ada pinjaman aktif.');
        }

        $paymentAmount = $loan->amount / $loan->duration; // Cicilan per bulan
        $paidAmount = $loan->payments()->sum('amount');
        $remainingAmount = $loan->amount - $paidAmount;

        if ($paymentAmount > $remainingAmount) {
            $paymentAmount = $remainingAmount; // Jika sisa lebih kecil dari cicilan
        }

        Payment::create([
            'user_id' => Auth::id(),
            'loan_id' => $loan->id,
            'amount' => $paymentAmount,
            'payment_date' => $request->payment_date,
            'status' => 'Lunas',
        ]);

        if ($paidAmount + $paymentAmount >= $loan->amount) {
            $loan->update(['status' => 'Lunas']);
        }

        return redirect()->route('dashboard')->with('success', 'Pembayaran cicilan berhasil!');
    }
    public function history(Request $request)
    {
        $sort = $request->input('sort', 'desc');
        $payments = Payment::where('user_id', Auth::id())->orderBy('payment_date', $sort)->get();
        return view('payment.history', compact('payments'));
    }
    
}