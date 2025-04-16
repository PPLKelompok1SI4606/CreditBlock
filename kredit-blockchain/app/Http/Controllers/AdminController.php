<?php

namespace App\Http\Controllers;

use App\Models\LoanApplication;
use App\Models\User;
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
    $loanApplications = LoanApplication::with('user')
        ->when($search, function ($query, $search) {
            return $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhere('id', 'like', "%{$search}%");
        })
        ->latest()
        ->get();

    $users = User::all(); // Ambil semua pengguna untuk tabel Daftar Pengguna
    $totalUsers = User::count();
    $activeLoans = LoanApplication::where('status', 'APPROVED')->count();
    $pendingLoans = LoanApplication::where('status', 'PENDING')->count();

    return view('admin.dashboard', compact('loanApplications', 'users', 'search', 'totalUsers', 'activeLoans', 'pendingLoans'));
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

    // Method ini sepertinya belum diimplementasikan, kita akan tambahkan untuk route admin.loan-applications
    public function loanApplications()
    {
        $loanApplications = LoanApplication::with('user')->latest()->get();
        return view('admin.loan-applications', compact('loanApplications'));
    }
}   