@extends('layouts.app')

@section('title', 'Riwayat Pembayaran')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-blue-50 to-gray-100 relative overflow-hidden">
    <!-- Subtle Particle Background -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="particle particle-1"></div>
        <div class="particle particle-2"></div>
        <div class="particle particle-3"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 relative z-10">
        <!-- Hero Section -->
        <div class="text-center mb-12 animate-fade-in">
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-800 tracking-tight">Riwayat Pembayaran</h1>
            <p class="mt-3 text-lg text-gray-600 max-w-2xl mx-auto">Lihat semua riwayat pembayaran cicilan Anda dengan mudah.</p>
        </div>

        <!-- Main Card -->
        <div class="relative bg-white bg-opacity-95 backdrop-blur-xl rounded-2xl shadow-2xl p-8 transition-all duration-500 hover:-translate-y-2 hover:shadow-3xl animate-fade-in">

            <div class="overflow-x-auto">
                <table class="w-full text-gray-700 text-sm">
                    <thead>
                        <tr class="bg-blue-50 text-gray-900">
                            <th class="px-6 py-4 text-left rounded-tl-lg font-medium tracking-wide">Pembayaran Cicilan pada Bulan (Cicilan ke-)</th>
                            <th class="px-6 py-4 text-left font-medium tracking-wide">Nominal</th>
                            <th class="px-6 py-4 text-left font-medium tracking-wide">Sisa Pembayaran</th>
                            <th class="px-6 py-4 text-left rounded-tr-lg font-medium tracking-wide">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php
                        $cumulativePaid = 0; // Track cumulative payments for the current loan
                        $currentLoanId = null; // Track the current loan to reset cumulative when loan changes
                    @endphp
                    @forelse ($payments as $payment)
                        @php
                            $loan = $payment->loan;
                            // Reset cumulative paid if the loan changes
                            if ($currentLoanId !== $loan->id) {
                                $cumulativePaid = 0;
                                $currentLoanId = $loan->id;
                            }
                            // Ambil bulan dan tahun berdasarkan installment_month
                            $startMonth = $loan->start_month;
                            $startYear = $loan->start_year;
                            $currentMonth = ($startMonth + $payment->installment_month - 2) % 12 + 1;
                            $currentYear = $startYear + intdiv($startMonth + $payment->installment_month - 2, 12);
                            $monthName = \Carbon\Carbon::create()->month($currentMonth)->format('F');
                            // Tambahkan pembayaran saat ini ke total kumulatif
                            $cumulativePaid += $payment->amount;
                            // Hitung sisa pembayaran
                            $remainingAmount = $loan->total_payment - $cumulativePaid;
                            // Tentukan status berdasarkan sisa pembayaran
                            $status = $remainingAmount <= 0 ? 'LUNAS' : 'Belum Lunas';
                        @endphp
                        <tr class="border-b border-gray-100 hover:bg-blue-50/50 transition-all duration-200">
                            <td class="px-6 py-4">{{ $monthName }} {{ $currentYear }} - Cicilan ke-{{ $payment->installment_month }}</td>
                            <td class="px-6 py-4 font-mono text-gray-800">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 font-mono text-gray-800">Rp {{ number_format($remainingAmount, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-block {{ $status === 'LUNAS' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }} text-xs font-medium px-2.5 py-1 rounded-full">
                                    {{ $status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">Tidak ada pembayaran yang belum lunas.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fadeIn 0.8s ease-out; }
        .animate-slide-up { animation: slideUp 0.5s ease-out; }

        /* Particle Animation */
        .particle {
            position: absolute;
            border-radius: 50%;
            background: rgba(59, 130, 246, 0.3);
            animation: float 15s infinite ease-in-out;
        }
        .particle-1 { width: 20px; height: 20px; top: 10%; left: 20%; animation-delay: 0s; }
        .particle-2 { width: 15px; height: 15px; top: 50%; left: 70%; animation-delay: 5s; }
        .particle-3 { width: 25px; height: 25px; top: 80%; left: 40%; animation-delay: 10s; }
        @keyframes float {
            0%, 100% { transform: translateY(0) translateX(0); opacity: 0.3; }
            50% { transform: translateY(-50px) translateX(20px); opacity: 0.6; }
        }
    </style>
</div>
@endsection
