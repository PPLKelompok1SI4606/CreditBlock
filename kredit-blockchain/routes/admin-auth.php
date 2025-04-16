<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\SupportMessageController;

// Login As Admin Tidak Perlu Login
Route::prefix('admin')->middleware('guest:admin')->group(function () {

    // Login
    Route::get('login', [LoginController::class, 'create'])->name('admin.login');
    Route::post('login', [LoginController::class, 'store']);

});

// Perlu Login
Route::prefix('admin')->middleware('auth:admin')->group(function () {

    // Dahsboard Admin
    Route::get('/admin-dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // LogOut
    Route::post('logout', [LoginController::class, 'destroy'])->name('admin.logout');

    //Verifikasi Pengajuan Pinjaman
    Route::get('/loan-applications', [AdminController::class, 'loanApplications'])->name('admin.loan-applications');
    Route::put('/loan-applications/{loanApplication}/status', [AdminController::class, 'updateStatus'])
        ->name('admin.loan-applications.update-status');

    //routes kontak dukungan (admin)
    Route::get('/support', [SupportMessageController::class, 'index'])->name('admin.support.index');
    Route::get('/support/{supportMessage}', [SupportMessageController::class, 'show'])->name('admin.support.show');
    Route::post('/support/{supportMessage}/respond', [SupportMessageController::class, 'respond'])->name('admin.support.respond');
});
