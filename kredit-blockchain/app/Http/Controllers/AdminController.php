<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LoanApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        // Handle search query for users
        $search = $request->query('search');
        $usersQuery = User::query();

        if ($search) {
            $usersQuery->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
        }

        // Fetch users with pagination
        $users = $usersQuery->paginate(10);

        // Fetch summary data
        $totalUsers = User::count();
        $activeLoans = LoanApplication::where('status', 'APPROVED')->count();
        $pendingLoans = LoanApplication::where('status', 'PENDING')->count();

        // Fetch loan applications with user relationship
        $loanApplications = LoanApplication::with('user')
            ->when($search, function ($query, $search) {
                return $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                })->orWhere('id', 'like', '%' . $search . '%');
            })
            ->paginate(10);

        // Pass data to the view
        return view('admin.dashboard', compact(
            'users',
            'totalUsers',
            'activeLoans',
            'pendingLoans',
            'loanApplications',
            'search'
        ));
    }

    public function deleteUser(User $user)
    {
        // Hapus semua aplikasi pinjaman terkait pengguna
        $user->loanApplications()->delete();
        // Hapus pengguna
        $user->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Pengguna berhasil dihapus.');
    }

    public function changePassword(Request $request, User $user)
    {
        // Validasi input
        $request->validate([
            'new_password' => ['required', 'string', 'min:8'],
        ]);

        // Update password pengguna
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('admin.dashboard')->with('success', 'Password pengguna berhasil diubah.');
    }

    // Existing methods
    public function loanApplications()
    {
        // Your existing logic for loan applications
    }

    public function updateStatus(Request $request, LoanApplication $loanApplication)
    {
        // Your existing logic for updating loan status
        $loanApplication->status = $request->status;
        $loanApplication->save();

        return redirect()->route('admin.dashboard')->with('success', 'Status pinjaman berhasil diperbarui.');
    }
}