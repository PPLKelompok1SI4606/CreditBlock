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
    Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments/store', [PaymentController::class, 'store'])->name('payments.store'); 
    Route::get('/payments/history', [PaymentController::class, 'history'])->name('payments.history');
});