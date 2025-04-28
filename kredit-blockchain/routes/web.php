<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoanCalculatorController;

Route::get('/', function () {
    return view('landingpage');
})->name('landingpage');

Route::get('/clear-session', function () {
    Auth::guard('web')->logout();
    Auth::guard('admin')->logout();
    session()->flush();
    return redirect('/admin/login');
});

Route::get('/test-auth', function () {
    return \Illuminate\Support\Facades\Auth::check() ? 'Authenticated' : 'Not authenticated';
});

Route::get('/test-middleware', function () {
    return 'Middleware works';
})->middleware('restrict.unverified');

Route::post('/calculate-loan', [LoanCalculatorController::class, 'calculate'])->name('calculate.loan');

require __DIR__.'/auth.php';
require __DIR__.'/admin-auth.php';
