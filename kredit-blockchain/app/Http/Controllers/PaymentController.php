<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoanApplication;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    // Menampilkan halaman pembuatan pembayaran
    
    public function create()
    {
        // Cari pinjaman aktif untuk user saat ini
        $loan = LoanApplication::where('user_id', Auth::id())->where('status', 'APPROVED')->first();

        // Jika tidak ada pinjaman aktif, buat pinjaman dummy
        if (!$loan) {
            $loan = LoanApplication::create([
                'user_id' => Auth::id(),
                'amount' => 5000000, // Jumlah pinjaman dummy (Rp 5.000.000)
                'duration' => 12, // Durasi pinjaman dummy (12 bulan)
                'status' => 'APPROVED', // Status pinjaman dummy
            ]);
        }

        // Hitung sisa pembayaran
        $paidAmount = $loan->payments()->sum('amount');
        $remainingAmount = $loan->amount - $paidAmount;

        return view('payments.create', compact('remainingAmount'));
    }
    /* public function create()
    {
        $loan = LoanApplication::where('user_id', Auth::id())->where('status', 'Aktif')->first();

        if (!$loan) {
            // Tetap tampilkan halaman dengan pesan bahwa tidak ada pinjaman aktif
            return view('payments.create', ['remainingAmount' => 0])
                ->with('error', 'Tidak ada pinjaman aktif.');
        }

        $paidAmount = $loan->payments()->sum('amount');
        $remainingAmount = $loan->amount - $paidAmount;

        return view('payments.create', compact('remainingAmount'));
    }*/

    public function store(Request $request)
    {
        $request->validate([
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|min:1',
        ]);
    
        // Cari pinjaman aktif untuk user saat ini
        $loan = LoanApplication::where('user_id', Auth::id())->where('status', 'APPROVED')->first();
    
        if (!$loan) {
            return redirect()->route('payments.create')->with('error', 'Tidak ada pinjaman aktif.');
        }
    
        // Simpan pembayaran ke database
        Payment::create([
            'user_id' => Auth::id(),
            'loan_application_id' => $loan->id,
            'amount' => $request->amount,
            'payment_date' => $request->payment_date,
            'status' => 'Lunas',
        ]);
    
        return redirect()->route('payments.history')->with('success', 'Pembayaran berhasil disimpan.');
    }

    // Menyimpan data pembayaran
    /* public function store(Request $request)
    {
        $request->validate([
            'payment_date' => 'required|date',
        ]);

        $loan = LoanApplication::where('user_id', Auth::id())->where('status', 'Aktif')->first();

        if (!$loan) {
            return redirect()->route('dashboard')->with('error', 'Tidak ada pinjaman aktif.');
        }

        $paymentAmount = $loan->duration > 0 ? $loan->amount / $loan->duration : 0; // Cicilan per bulan
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
    }*/

    public function history(Request $request)
    {
        $payments = Payment::where('user_id', Auth::id())
            ->orderBy('payment_date', $request->get('sort', 'desc'))
            ->get();
    
        return view('payments.history', compact('payments'));
    }

    // Menampilkan riwayat pembayaran
    /*public function history(Request $request)
    {
        $payments = Payment::where('user_id', Auth::id())
        ->orderBy('payment_date', $request->get('sort', 'desc'))
        ->get();

        return view('payments.history', compact('payments'));
    }*/
}