<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoanApplicationController;
use App\Http\Controllers\SupportMessageController;

// Login As User Tidak Perlu Login
Route::middleware('guest')->group(function () {

    // Welcome
    Route::get('/welcome', function () {
        return view('auth.welcome');
    })->name('welcome');

    // KYC
    Route::get('/kyc', function () {
        return view('auth.kyc');
    })->name('kyc');

    // Register
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    // Login
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

});

// Perlu Login
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {return view('dashboard');})->name('dashboard');

    Route::get('/loan-applications/create', [LoanApplicationController::class, 'create'])
        ->name('loan-applications.create');

    Route::post('/loan-applications', [LoanApplicationController::class, 'store'])
        ->name('loan-applications.store');

        Route::get('/loan-applications/index', [LoanApplicationController::class, 'index'])
        ->name('loan-applications.index');

    // LogOut
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    //routes kontak dukungan (user)
    Route::get('/support', [SupportMessageController::class, 'index'])->name('support.index');
    Route::get('/support/create', [SupportMessageController::class, 'create'])->name('support.create');
    Route::post('/support', [SupportMessageController::class, 'store'])->name('support.store');
    Route::get('/support/{supportMessage}', [SupportMessageController::class, 'show'])->name('support.show');
});

