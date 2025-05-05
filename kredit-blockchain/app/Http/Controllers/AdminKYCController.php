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
        $user->update(['status_kyc' => 'approved']);
        return redirect()->route('admin.dashboard')->with('status', 'KYC approved successfully.');
    }

    public function reject(Request $request, User $user): RedirectResponse
    {
        $user->update(['status_kyc' => 'rejected']);
        return redirect()->route('admin.dashboard')->with('status', 'KYC rejected.');
    }
}