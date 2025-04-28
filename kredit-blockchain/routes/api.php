<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CreditController;
use App\Http\Controllers\WalletController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/wallet/address', [App\Http\Controllers\WalletController::class, 'getWalletAddress'])->name('wallet.address');
Route::post('/wallet/store', [WalletController::class, 'store'])->name('wallet.store');
Route::post('/wallet/verify', [WalletController::class, 'verifyWallet']);

Route::post('/credit/request', [CreditController::class, 'requestCredit']);
