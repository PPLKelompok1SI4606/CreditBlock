<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminKYCController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\SupportMessageController;
use App\Http\Controllers\LoanCalculatorController;

// Login As Admin Tidak Perlu Login
Route::prefix('admin')->middleware('guest:admin')->group(function () {
    // Login
    Route::get('login', [LoginController::class, 'create'])->name('admin.login');
    Route::post('login', [LoginController::class, 'store']);
});

// Perlu Login
Route::prefix('admin')->middleware('auth:admin')->group(function () {
    // Dashboard Admin
    Route::get('/admin-dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // LogOut
    Route::post('logout', [LoginController::class, 'destroy'])->name('admin.logout');

    // Verifikasi Pengajuan Pinjaman
    Route::get('/loan-applications', [AdminController::class, 'loanApplications'])->name('admin.loan-applications');
    Route::put('/loan-applications/{loanApplication}/status', [AdminController::class, 'updateStatus'])
        ->name('admin.loan-applications.update-status');

    // Routes kontak dukungan (admin)
    Route::get('/support', [SupportMessageController::class, 'index'])->name('admin.support.index');
    Route::get('/support/{supportMessage}', [SupportMessageController::class, 'show'])->name('admin.support.show');
    Route::post('/support/{supportMessage}/respond', [SupportMessageController::class, 'respond'])->name('admin.support.respond');

    Route::get('/admin/kyc/{user}/verify', [AdminKYCController::class, 'verify'])->name('admin.kyc.verify');
    Route::post('/admin/kyc/{user}/approve', [AdminKYCController::class, 'approve'])->name('admin.kyc.approve');
    Route::post('/admin/kyc/{user}/reject', [AdminKYCController::class, 'reject'])->name('admin.kyc.reject');
    
    //Routes untuk mengelola pengguna
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::delete('/admin/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.delete-user');
    Route::patch('/admin/users/{user}/change-password', [AdminController::class, 'changePassword'])->name('admin.change-password');
});
