<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\LoanApplicationController; // Tambahkan import
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\SupportMessageController;

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

    // Dahsboard Admin
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

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
