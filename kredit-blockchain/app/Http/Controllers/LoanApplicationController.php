<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoanApplication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LoanApplicationController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth'); // Ensure user is authenticated
    // }

    public function create()
    {
        return view('loan-applications.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000',
            'duration' => 'required|integer|min:1|max:60',
            'document' => 'required|file|mimes:pdf,jpg,png|max:2048', // Max 2MB
        ]);

        $documentPath = null;
        if ($request->hasFile('document')) {
            $documentPath = $request->file('document')->store('documents', 'public');
        }

        LoanApplication::create([
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'duration' => $request->duration,
            'document_path' => $documentPath,
            'status' => 'PENDING',
        ]);

        return redirect()->route('dashboard')->with('success', 'Loan application submitted successfully!');
    }
}
