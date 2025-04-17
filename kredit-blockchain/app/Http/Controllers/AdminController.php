<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LoanApplication;
use Illuminate\Http\Request;

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

    // Existing methods (e.g., loanApplications, updateStatus)
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
