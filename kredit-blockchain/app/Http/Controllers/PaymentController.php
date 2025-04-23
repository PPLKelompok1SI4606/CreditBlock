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
        // Cari pinjaman aktif untuk user saat ini
        $loan = LoanApplication::where('user_id', Auth::id())
            ->whereIn('status', ['APPROVED', 'PENDING']) // Periksa status pinjaman
            ->first();
    
        // Jika tidak ada pinjaman aktif
        if (!$loan) {
            return redirect()->route('dashboard')->with('error', 'Tidak ada pinjaman aktif.');
        }
    
        // Jika status pinjaman adalah PENDING
        if ($loan->status === 'PENDING') {
            return redirect()->route('dashboard')->with('error', 'Tidak ada peminjaman yang aktif dan disetujui.');
        }
    
        // Jika status pinjaman adalah APPROVED
        // Hitung sisa pembayaran
        $paidAmount = $loan->payments()->sum('amount'); // Total pembayaran yang sudah dilakukan
        $remainingAmount = $loan->amount - $paidAmount; // Sisa pembayaran
    
        // Kirim data ke view
        return view('payments.create', compact('loan', 'remainingAmount'));
    }

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

    public function history(Request $request)
    {
        $payments = Payment::where('user_id', Auth::id())
            ->orderBy('payment_date', $request->get('sort', 'desc'))
            ->get();
    
        return view('payments.history', compact('payments'));
    }

}