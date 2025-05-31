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
            <!-- Action Buttons -->
            <div class="mb-8 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-4">
                    <a href="{{ route('payments.export-pdf') }}"
                       class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white rounded-lg font-medium text-sm tracking-wider transition-all duration-300 hover:bg-blue-700 hover:ring-2 hover:ring-blue-200 hover:ring-opacity-50">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Export PDF
                    </a>
                </div>

                <!-- Sort Dropdown -->
                <form method="GET" action="{{ route('payments.history') }}" class="relative group">
                    <select name="sort" id="sort" onchange="this.form.submit()"
                            class="py-2.5 pl-10 pr-4 w-full sm:w-48 rounded-lg border border-gray-200 bg-white/80 text-gray-800 focus:border-blue-600 focus:ring-2 focus:ring-blue-200 focus:outline-none sm:text-sm transition-all duration-300 hover:border-blue-300">
                        <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Tanggal Terbaru</option>
                        <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Tanggal Terlama</option>
                    </select>
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-blue-500 group-hover:text-blue-600 transition-colors duration-300">
                        <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path>
                        </svg>
                    </span>
                </form>
            </div>

            <!-- Table Container -->
            <div class="overflow-x-auto rounded-xl border border-gray-100">
                <table class="w-full text-gray-700">
                    <thead>
                        <tr class="bg-gray-50">
                        </tr>
                    <tbody class="divide-y divide-gray-100">
                        @php
                            $cumulativePaid = 0;
                            $currentLoanId = null;
                        @endphp
                        @forelse ($payments as $payment)
                            @php
                                $loan = $payment->loan;
                                if ($currentLoanId !== $loan->id) {
                                    $cumulativePaid = 0;
                                    $currentLoanId = $loan->id;
                                }
                                $startMonth = $loan->start_month;
                                $startYear = $loan->start_year;
                                $currentMonth = ($startMonth + $payment->installment_month - 2) % 12 + 1;
                                $currentYear = $startYear + intdiv($startMonth + $payment->installment_month - 2, 12);
                                $monthName = \Carbon\Carbon::create()->month($currentMonth)->format('F');
                                $cumulativePaid += $payment->amount;
                                $remainingAmount = $loan->total_payment - $cumulativePaid;
                                $status = $remainingAmount <= 0 ? 'LUNAS' : 'Belum Lunas';
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-full bg-blue-100 text-blue-600">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $monthName }} {{ $currentYear }}</div>
                                            <div class="text-sm text-gray-500">Cicilan ke-{{ $payment->installment_month }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 font-mono">Rp {{ number_format($payment->amount, 0, ',', '.') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 font-mono">Rp {{ number_format($remainingAmount, 0, ',', '.') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $status === 'LUNAS' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <p class="text-lg font-medium">Tidak ada pembayaran yang ditemukan</p>
                                        <p class="text-sm mt-1">Belum ada riwayat pembayaran untuk ditampilkan</p>
                                    </div>
                                </td>
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
