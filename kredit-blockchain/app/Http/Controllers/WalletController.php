<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'wallet_address' => 'required|string|size:42|unique:users,wallet_address',
        ]);

        $user = Auth::user();
        $user->wallet_address = $request->wallet_address;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Wallet address saved successfully',
        ]);
    }
}
