<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\LoanApplication;
use App\Models\User;
use App\Http\Controllers\Controller;

class LoanApplicationController extends Controller
{
    public function index()
    {
        $users = User::all();
        $loanApplications = LoanApplication::with('user')->get();

        return view('admin.dashboard', compact('users', 'loanApplications'));
    }

    public function approveLoan($id)
    {
        $loan = LoanApplication::findOrFail($id);
        $loan->status = 'APPROVED'; // Ubah dari 'disetujui' ke 'APPROVED'
        $loan->save();

        return redirect()->route('admin.dashboard')->with('success', 'Pengajuan pinjaman berhasil disetujui.');
    }

    public function rejectLoan($id)
    {
        $loan = LoanApplication::findOrFail($id);
        $loan->status = 'REJECTED'; // Ubah dari 'ditolak' ke 'REJECTED'
        $loan->save();

        return redirect()->route('admin.dashboard')->with('success', 'Pengajuan pinjaman berhasil ditolak.');
    }
}