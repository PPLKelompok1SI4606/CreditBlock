<?php

namespace App\Http\Controllers;

use App\Models\LoanApplication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(Request $request): View
    {
        $search = $request->query('search');

        $users = User::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        })->where('is_admin', false)->paginate(10);

        $pendingKycUsers = User::whereNotNull('id_document')
            ->where('is_verified', false)
            ->get();

        $totalUsers = User::where('is_admin', false)->count();
        $activeLoans = LoanApplication::where('status', 'APPROVED')->count();
        $pendingLoans = LoanApplication::where('status', 'PENDING')->count();

        $loanApplications = LoanApplication::when($search, function ($query, $search) {
            return $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        })->with('user')->paginate(10);

        return view('admin.dashboard', compact(
            'users',
            'pendingKycUsers',
            'totalUsers',
            'activeLoans',
            'pendingLoans',
            'loanApplications',
            'search'
        ));
    }

    public function loanApplications(): View
    {
        $loanApplications = LoanApplication::with('user')->paginate(10);
        return view('admin.loan-applications', compact('loanApplications'));
    }

    public function updateStatus(Request $request, LoanApplication $loanApplication): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'in:APPROVED,REJECTED'],
        ]);

        $loanApplication->update(['status' => $request->status]);

        return redirect()->route('admin.loan-applications')->with('status', 'Status pinjaman berhasil diperbarui.');
    }

    public function deleteUser(User $user): RedirectResponse
    {
        if ($user->is_admin) {
            return redirect()->route('admin.dashboard')->with('error', 'Tidak dapat menghapus akun admin.');
        }

        $user->delete();
        return redirect()->route('admin.dashboard')->with('status', 'Pengguna berhasil dihapus.');
    }

    public function changePassword(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('admin.dashboard')->with('status', 'Password pengguna berhasil diubah.');
    }
}
