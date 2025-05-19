<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoanPdfController;

Route::get('/', function () {
    return view('landingpage');
})->name('landingpage');

Route::get('/clear-session', function () {
    Auth::guard('web')->logout();
    Auth::guard('admin')->logout();
    session()->flush();
    return redirect('/admin/login');
});

// Preview Image
Route::get('/preview-email', function () {
    $user = App\Models\User::first();
    return new App\Mail\KYCVerificationMail($user, 'admin@acreditblock.com');
});

Route::get('/loan-history/pdf', [LoanPdfController::class, 'exportPdf'])->name('loan.exportPdf');

require __DIR__.'/auth.php';
require __DIR__.'/admin-auth.php';
