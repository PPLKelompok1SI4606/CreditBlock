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
            'is_verified' => Auth::check() ? Auth::user()->is_verified : null,
        ]);

        if (Auth::check() && !Auth::user()->is_verified) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Akun Anda belum diverifikasi. Harap menunggu persetujuan admin.');
        }

        return $next($request);
    }

}
