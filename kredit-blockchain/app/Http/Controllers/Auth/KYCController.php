<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\KYCVerificationMail;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use App\Notifications\KYCVerificationNotification;

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
            'is_verified' => false
        ]);

        try {
            // Send email to admin using Mailable
            $adminEmail = Config::get('mail.admin_email', 'acreditblock@gmail.com');
            Mail::to($adminEmail)->send(new KYCVerificationMail($user, $adminEmail));
        } catch (\Exception $e) {
            // Log the error and return a response indicating the issue
            \Log::error('Failed to send KYC email: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'KYC submitted, but failed to send email. Please contact support.'
            ], 500);
        }

        // Remove email from session
        $request->session()->forget('email');

        return response()->json([
            'success' => true,
            'message' => 'Akun Anda telah berhasil diregistrasi! Silakan tunggu verifikasi dari admin untuk dapat login.'
        ]);
    }
}
