<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RestrictUnverifiedUser
{
    public function handle(Request $request, Closure $next)
    {
        Log::info('RestrictUnverifiedUser middleware called', [
            'user_id' => Auth::id(),
            'status_kyc' => Auth::check() ? Auth::user()->status_kyc : null,
            'path' => $request->path(),
        ]);

        // Izinkan akses ke halaman KYC untuk semua pengguna (guest atau login)
        if ($request->path() === 'kyc') {
            return $next($request);
        }

        // Batasi akses ke halaman lain jika KYC belum disetujui
        if (Auth::check() && Auth::user()->status_kyc != 'approved') {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Akun Anda belum diverifikasi atau telah ditolak. Harap hubungi admin.');
        }

        return $next($request);
    }
}