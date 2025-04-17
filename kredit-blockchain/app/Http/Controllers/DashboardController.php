<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil 3 pembayaran terbaru
        $payments = Payment::where('user_id', Auth::id())
            ->orderBy('payment_date', 'desc')
            ->limit(3)
            ->get();

        // Kirim data ke view
        return view('dashboard', compact('payments'));
    }

    /* public function index()
    {
        return view('dashboard');
    } */
}
