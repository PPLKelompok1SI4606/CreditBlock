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

    public function index(Request $request)
    {
        $search = $request->input('search');
        $applications = LoanApplication::with('user')
            ->when($search, function ($query, $search) {
                return $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhere('id', 'like', "%{$search}%");
            })
            ->latest()
            ->get();

        $totalUsers = \App\Models\User::count();
        $activeLoans = LoanApplication::where('status', 'APPROVED')->count();
        $pendingLoans = LoanApplication::where('status', 'PENDING')->count();

        return view('admin.dashboard', compact('applications', 'search', 'totalUsers', 'activeLoans', 'pendingLoans'));
    }

    public function updateStatus(Request $request, LoanApplication $loanApplication)
    {
        $request->validate([
            'status' => 'required|in:APPROVED,REJECTED',
        ]);

        $loanApplication->update([
            'status' => $request->status,
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Status pengajuan berhasil diperbarui.');
    }
}
