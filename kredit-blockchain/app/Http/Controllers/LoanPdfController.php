<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\LoanApplication;

class LoanPdfController extends Controller
{
    public function exportPdf()
    {
        $loanApplications = LoanApplication::where('user_id', auth()->id())->get();

        $pdf = Pdf::loadView('loan-applications.export-pdf', compact('loanApplications'))->setPaper('a4', 'landscape');
        return $pdf->stream('riwayat_peminjaman.pdf');
    }
}
