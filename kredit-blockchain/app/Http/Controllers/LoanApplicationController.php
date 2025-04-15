<?php

namespace App\Http\Controllers;

use App\Models\LoanApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LoanApplicationController extends Controller
{
    public function create()
    {
        return view('loan-applications.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000000',
            'duration' => 'required|integer|min:1|max:60',
            'document' => 'required|file|mimes:pdf,jpg,png|max:2048',
        ]);

        try {
            $documentPath = $request->file('document')->store('documents', 'public');

            LoanApplication::create([
                'user_id' => Auth::id(),
                'amount' => $request->amount,
                'duration' => $request->duration,
                'document_path' => $documentPath,
                'status' => 'PENDING',
            ]);

            return redirect()->route('dashboard')
                ->with('success', 'Pengajuan pinjaman berhasil dikirim.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menyimpan pengajuan: ' . $e->getMessage());
        }
    }
}
