<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;


Route::get('/', function () {
    return view('landingpage');
})->name('landingpage');

Route::get('/clear-session', function () {
    Auth::guard('web')->logout();
    Auth::guard('admin')->logout();
    session()->flush();
    return redirect('/admin/login');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin-auth.php';
