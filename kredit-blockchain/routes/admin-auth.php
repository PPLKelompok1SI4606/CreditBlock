<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\LoanApplicationController; // Tambahkan import

// Login As Admin Tidak Perlu Login
Route::prefix('admin')->middleware('guest:admin')->group(function () {
    // Login
    Route::get('login', [LoginController::class, 'create'])->name('admin.login');
    Route::post('login', [LoginController::class, 'store']);
});

// Perlu Login
Route::prefix('admin')->middleware('auth:admin')->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', [LoanApplicationController::class, 'index'])->name('admin.dashboard');

    // Route untuk mengubah status pengajuan pinjaman
    Route::post('/loan-applications/{id}/approve', [LoanApplicationController::class, 'approveLoan'])->name('admin.loan-applications.approve');
    Route::post('/loan-applications/{id}/reject', [LoanApplicationController::class, 'rejectLoan'])->name('admin.loan-applications.reject');

    // LogOut
    Route::post('logout', [LoginController::class, 'destroy'])->name('admin.logout');
});