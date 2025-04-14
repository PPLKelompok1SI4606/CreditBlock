<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoanApplicationController;

// Login As Admin Tidak Perlu Login
Route::prefix('admin')->middleware('guest:admin')->group(function () {

    // Login
    Route::get('login', [LoginController::class, 'create'])->name('admin.login');
    Route::post('login', [LoginController::class, 'store']);

});

// Perlu Login
Route::prefix('admin')->middleware('auth:admin')->group(function () {

    // Dahsboard Admin
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // LogOut
    Route::post('logout', [LoginController::class, 'destroy'])->name('admin.logout');

    //Verifikasi Pengajuan Pinjaman
    Route::get('/loan-applications', [AdminController::class, 'loanApplications'])->name('admin.loan-applications');
    Route::put('/loan-applications/{loanApplication}/status', [AdminController::class, 'updateStatus'])
        ->name('admin.loan-applications.update-status');
});
