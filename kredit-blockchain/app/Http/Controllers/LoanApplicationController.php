<?php
namespace App\Http\Controllers;

use App\Models\LoanApplication;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class LoanApplicationController extends Controller
{
    public function index()
    {
        $loanApplications = LoanApplication::where('user_id', Auth::id())
            ->orderBy('start_year', 'desc')
            ->orderBy('start_month', 'desc')
            ->get();

        return view('loan-applications.index', compact('loanApplications'));
    }

    public function dashboard(Request $request)
    {
        $user = Auth::user();

        // Ambil pinjaman untuk grafik
        $loanApplications = LoanApplication::where('user_id', $user->id)
            ->whereIn('status', ['APPROVED', 'Belum Lunas', 'Lunas'])
            ->whereNotNull('approved_at')
            ->orderBy('approved_at', 'desc')
            ->get();

        // Format data untuk grafik
        $chartData = $loanApplications->map(function ($loan) {
            return [
                'label' => $loan->approved_at->translatedFormat('d M Y'),
                'amount' => $loan->amount,
                'status' => $loan->status,
                'duration' => $loan->duration,
                'end_label' => Carbon::create($loan->end_year, $loan->end_month, 1)->translatedFormat('M Y'),
            ];
        })->toArray();

        // Data untuk "Pinjaman Saya"
        $loans = LoanApplication::where('user_id', $user->id)
            ->where('status', 'APPROVED')
            ->get();
        $totalAmount = $loans->sum('amount');
        $totalPaid = $loans->sum(function ($loan) {
            return $loan->payments()->sum('amount');
        });
        $remainingAmount = $totalAmount - $totalPaid;
        $monthlyInstallment = $loans->sum(function ($loan) {
            return $loan->amount / $loan->duration;
        });
        $nextDueDate = $loans->isNotEmpty() ? now()->addMonth()->format('d M Y') : '-';
        $loanStatus = $loans->isNotEmpty() ? 'Aktif' : 'Tidak Aktif';
        $loanStatusStyle = $loans->isNotEmpty() ? 'bg-blue-100 text-blue-700 animate-pulse' : 'bg-gray-100 text-gray-700';

        // Data untuk "Pengajuan Pinjaman"
        $latestLoan = LoanApplication::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->first();
        $latestLoanData = $latestLoan ? [
            'remainingAmount' => $latestLoan->status === 'APPROVED' ? ($latestLoan->amount - $latestLoan->payments()->sum('amount')) : $latestLoan->amount,
            'monthlyInstallment' => $latestLoan->status === 'APPROVED' ? ($latestLoan->amount / $latestLoan->duration) : 0,
            'nextDueDate' => $latestLoan->status === 'APPROVED' ? now()->addMonth()->format('d M Y') : '-',
            'duration' => $latestLoan->duration,
            'status' => $latestLoan->status,
        ] : null;

        // Ambil riwayat pembayaran
        $payments = Payment::whereHas('loanApplication', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->orderBy('payment_date', 'desc')->get();

        return view('dashboard', compact(
            'chartData',
            'payments',
            'loans',
            'totalAmount',
            'remainingAmount',
            'monthlyInstallment',
            'nextDueDate',
            'loanStatus',
            'loanStatusStyle',
            'latestLoan',
            'latestLoanData'
        ));
    }

    public function history()
    {
        // Ambil semua data pinjaman untuk user saat ini, termasuk PENDING dan REJECTED
        $loanApplications = LoanApplication::where('user_id', Auth::id())
            ->orderBy('start_year', 'desc')
            ->orderBy('start_month', 'desc')
            ->get();

        return view('loan-applications.index', compact('loanApplications'));
    }

    public function create()
    {
        // Check if user has an existing unpaid loan
        $hasUnpaidLoan = LoanApplication::where('user_id', Auth::id())
            ->whereIn('status', ['PENDING', 'APPROVED', 'Belum Lunas'])
            ->exists();

        return view('loan-applications.create', compact('hasUnpaidLoan'));
    }

    public function store(Request $request)
    {
        // Check again to prevent race conditions
        $existingLoan = LoanApplication::where('user_id', Auth::id())
            ->whereIn('status', ['PENDING', 'APPROVED', 'Belum Lunas'])
            ->first();

        if ($existingLoan) {
            return redirect()->route('dashboard')
                ->with('error', 'Anda tidak dapat mengajukan pinjaman baru karena masih memiliki pinjaman yang belum lunas atau sedang diproses.');
        }

        $request->validate([
            'amount' => 'required|numeric|min:1000000',
            'duration' => 'required|integer|min:1|max:60',
            'interest_rate' => 'required|numeric|in:5,10',
            'start_month' => 'required|integer|min:1|max:12',
            'start_year' => 'required|integer|min:2025',
            'end_month' => 'required|integer|min:1|max:12',
            'end_year' => 'required|integer|min:2025',
            'document' => 'required|file|mimes:pdf,jpg,png|max:2048',
        ]);

        // Validate that end date is after start date
        $startDate = \Carbon\Carbon::create($request->start_year, $request->start_month, 1);
        $endDate = \Carbon\Carbon::create($request->end_year, $request->end_month, 1);

        if ($endDate->lessThanOrEqualTo($startDate)) {
            return redirect()->back()
                ->with('error', 'Tanggal selesai pinjaman harus setelah tanggal mulai pinjaman.')
                ->withInput();
        }

        // Validate interest rate based on duration
        $duration = $request->duration;
        $expectedInterestRate = $duration <= 6 ? 5 : 10;
        if ($request->interest_rate != $expectedInterestRate) {
            return redirect()->back()
                ->with('error', 'Suku bunga harus ' . $expectedInterestRate . '% untuk durasi ' . $duration . ' bulan.')
                ->withInput();
        }

        try {
            $documentPath = $request->file('document')->store('documents', 'public');

            // Hitung total pembayaran (pokok + bunga)
            $interestAmount = ($request->amount * $request->interest_rate) / 100; // Bunga
            $totalPayment = $request->amount + $interestAmount; // Total pembayaran

            LoanApplication::create([
                'user_id' => Auth::id(),
                'amount' => $request->amount,
                'duration' => $request->duration,
                'interest_rate' => $request->interest_rate,
                'total_payment' => $totalPayment,
                'start_month' => $request->start_month,
                'start_year' => $request->start_year,
                'end_month' => $request->end_month,
                'end_year' => $request->end_year,
                'document_path' => $documentPath,
                'status' => 'PENDING',
            ]);

            return redirect()->route('loan-applications.history') // Ubah redirect ke halaman riwayat
                ->with('success', 'Pengajuan pinjaman berhasil dikirim dan menunggu persetujuan admin.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menyimpan pengajuan: ' . $e->getMessage());
        }
    }

    public function checkLoanStatus()
    {
        $loanApplication = LoanApplication::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->first();

        $remainingAmount = 0;

        if ($loanApplication && in_array($loanApplication->status, ['APPROVED', 'Belum Lunas'])) {
            // Hitung total pembayaran yang sudah dilakukan
            $totalPaid = $loanApplication->payments->sum('amount');

            // Hitung sisa pembayaran
            $remainingAmount = $loanApplication->total_payment - $totalPaid;

            // Update status to Lunas if fully paid
            if ($remainingAmount <= 0 && $loanApplication->status !== 'Lunas') {
                $loanApplication->update(['status' => 'Lunas']);
            }
        }

        return view('payments.create', compact('loanApplication', 'remainingAmount'));
    }

    public function getLoanHistoryChartData()
    {
        $data = LoanApplication::where('user_id', Auth::id())
            ->whereIn('status', ['APPROVED', 'Belum Lunas', 'Lunas']) // Hanya ambil status yang disetujui
            ->orderBy('start_year', 'asc')
            ->orderBy('start_month', 'asc')
            ->get()
            ->map(function ($item) {
                return [
                    'label' => \Carbon\Carbon::create($item->start_year, $item->start_month, 1)->translatedFormat('F Y'),
                    'amount' => (float) $item->amount,
                    'status' => (string) $item->status,
                    'duration' => (int) $item->duration,
                    'end_label' => \Carbon\Carbon::create($item->end_year, $item->end_month, 1)->translatedFormat('F Y'),
                ];
            })->values()->toArray();

        return response()->json($data);
    }
}