<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoanApplicationController;
use App\Http\Controllers\PaymentController;

Route::get('/', function () {
    return view('landingpage');
});


Route::get('/admin-dashboard', [AdminController::class, 'index'])->name('admin.dashboard'); // Daftar pengguna & pinjaman aktif
require __DIR__.'/auth.php';
require __DIR__.'/admin-auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/payment/create', [PaymentController::class, 'create'])->name('payment.create');
    Route::post('/payment', [PaymentController::class, 'store'])->name('payment.store');
    Route::get('/payment/history', [PaymentController::class, 'history'])->name('payment.history');
});
