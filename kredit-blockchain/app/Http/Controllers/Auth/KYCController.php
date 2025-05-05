<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class KYCController extends Controller
{
    public function create()
    {
        return view('auth.kyc');
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'id_type' => ['required', 'in:ktp,SIM'],
            'id_document' => ['required', 'file', 'mimes:jpeg,png', 'max:2048'],
            'check' => ['required', 'accepted'],
        ]);

        $user = User::where('email', $request->session()->get('email'))->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Please register first.'
            ], 422);
        }

        // Store the uploaded document
        $path = $request->file('id_document')->store('kyc_documents', 'public');

        // Update user with KYC details
        $user->update([
            'id_type' => $request->id_type,
            'id_document' => $path,
        ]);

        // Remove email from session
        $request->session()->forget('email');

        return response()->json([
            'success' => true,
            'message' => 'Akun Anda telah berhasil diregistrasi! Silakan tunggu verifikasi dari admin untuk dapat login.'
        ]);
    }
}
