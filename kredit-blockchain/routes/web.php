<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoanApplicationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
// Route::get('/loan-applications/create', [LoanApplicationController::class, 'create'])->name('loan-applications.create');
// Route::post('/loan-applications', [LoanApplicationController::class, 'store'])->name('loan-applications.store');

Route::get('/loan-applications/create', function () {
    return view('loan-applications.create');
})->name('loan-applications.create');

Route::post('/loan-applications', function () {
    // Temporary handler for form submission
    return redirect()->route('dashboard')->with('success', 'Loan application submitted!');
})->name('loan-applications.store');

Route::get('/admin-dashboard', [AdminController::class, 'index'])->name('admin.dashboard'); // Daftar pengguna & pinjaman aktif
