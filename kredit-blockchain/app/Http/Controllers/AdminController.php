<?php

namespace App\Http\Controllers;

use App\Models\LoanApplication;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['auth', 'is_admin']);
    // }

    public function index()
    {
        $totalUsers = \App\Models\User::count();
        $activeLoans = LoanApplication::where('status', 'APPROVED')->count();
        $pendingLoans = LoanApplication::where('status', 'PENDING')->count();
        return view('admin.dashboard', compact('totalUsers', 'activeLoans', 'pendingLoans'));
    }

    public function loanApplications()
    {
        $applications = LoanApplication::with('user')->latest()->get();
        return view('admin.loan-applications.index', compact('applications'));
    }

    public function updateStatus(Request $request, LoanApplication $loanApplication)
    {
        $request->validate([
            'status' => 'required|in:APPROVED,REJECTED',
        ]);

        $loanApplication->update([
            'status' => $request->status,
        ]);

        return redirect()->route('admin.loan-applications')
            ->with('success', 'Status pengajuan berhasil diperbarui.');
    }
}
