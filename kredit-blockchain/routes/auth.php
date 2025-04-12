<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

// Login As User Tidak Perlu Login
Route::middleware('guest')->group(function () {

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

    Route::get('/loan-applications/create', function () {
        return view('loan-applications.create');
    })->name('loan-applications.create');

    Route::post('/loan-applications', function () {
        // Temporary handler for form submission
        return redirect()->route('dashboard')->with('success', 'Loan application submitted!');
    })->name('loan-applications.store');

    // LogOut
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
