<?php

namespace App\Http;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Auth\KYCController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoanCalculatorController;
use App\Http\Controllers\SupportMessageController;
use App\Http\Controllers\LoanApplicationController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Login As User Tidak Perlu Login
Route::middleware('guest')->group(function () {

    // Welcome
    Route::get('/welcome', function () {
        return view('auth.welcome');
    })->name('welcome');

    // KYC
    Route::get('/kyc', [KYCController::class, 'create'])->name('kyc');
    Route::post('/kyc', [KYCController::class, 'store'])->name('kyc.store');

    // Register
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    // Login
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::post('/calculate-loan', [LoanCalculatorController::class, 'calculate'])->name('calculate.loan');

});

// Perlu Login
Route::middleware(['auth', 'univerified'])->group(function () {

    // Dashboard untuk pengguna yang sudah login
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rute untuk pembayaran
    Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create'); // Form pembayaran
    Route::post('/payments/store', [PaymentController::class, 'store'])->name('payments.store'); // Proses pembayaran
    Route::get('/payments/history', [PaymentController::class, 'history'])->name('payments.history'); // Riwayat pembayaran

    // Rute untuk memeriksa status pinjaman
    Route::get('/payments/check-loan-status', [LoanApplicationController::class, 'checkLoanStatus'])->name('payments.check-loan-status');
    Route::get('/payments/all-history', [PaymentController::class, 'allHistory'])->name('payments.all-history');

    // LogOut
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');


    // Form Pengajuan Pinjaman
    Route::get('/loan-applications/create', [LoanApplicationController::class, 'create'])
        ->name('loan-applications.create');
    Route::post('/loan-applications', [LoanApplicationController::class, 'store'])
        ->name('loan-applications.store');
    Route::get('/loan-applications/index', [LoanApplicationController::class, 'index'])
    ->name('loan-applications.index');

    //routes kontak dukungan (user)
    Route::get('/support', [SupportMessageController::class, 'index'])->name('support.index');
    Route::get('/support/create', [SupportMessageController::class, 'create'])->name('support.create');
    Route::post('/support', [SupportMessageController::class, 'store'])->name('support.store');
    Route::get('/support/{supportMessage}', [SupportMessageController::class, 'show'])->name('support.show');

    //route Connect Metamask Wallet
    Route::post('/wallet/store', [WalletController::class, 'store'])->name('wallet.store');
});
