<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landingpage');
})->name('landingpage');

Route::get('/clear-session', function () {
    Auth::guard('web')->logout();
    Auth::guard('admin')->logout();
    session()->flush();
    return redirect('/admin/login');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin-auth.php';

// Route::middleware(['auth'])->group(function () {
//     // Dashboard untuk pengguna yang sudah login
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

//     // Rute untuk pembayaran
//     Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create'); // Form pembayaran
//     Route::post('/payments/store', [PaymentController::class, 'store'])->name('payments.store'); // Proses pembayaran
//     Route::get('/payments/history', [PaymentController::class, 'history'])->name('payments.history'); // Riwayat pembayaran

//     // Rute untuk memeriksa status pinjaman
//     Route::get('/payments/check-loan-status', [LoanApplicationController::class, 'checkLoanStatus'])->name('payments.check-loan-status');

//     Route::get('/payments/all-history', [PaymentController::class, 'allHistory'])->name('payments.all-history');
// });
