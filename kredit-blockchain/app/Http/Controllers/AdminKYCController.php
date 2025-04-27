<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminKYCController extends Controller
{
    public function verify(User $user)
    {
        return view('admin.kyc.verify', compact('user'));
    }

    public function approve(Request $request, User $user): RedirectResponse
    {
        $user->update(['is_verified' => true]);
        return redirect()->route('admin.kyc.verify', $user->id)->with('status', 'KYC approved successfully.');
    }

    public function reject(Request $request, User $user): RedirectResponse
    {
        $user->update(['id_type' => null, 'id_document' => null]);
        return redirect()->route('admin.kyc.verify', $user->id)->with('status', 'KYC rejected.');
    }
}
