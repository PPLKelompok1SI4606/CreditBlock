@extends('layouts.app')

@section('title', 'Pembayaran Cicilan')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-blue-50 to-gray-100 relative overflow-hidden">
    <!-- Subtle Particle Background -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="particle particle-1"></div>
        <div class="particle particle-2"></div>
        <div class="particle particle-3"></div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 relative z-10">
        <!-- Hero Section -->
        <div class="text-center mb-12 animate-fade-in">
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-800 tracking-tight">Pembayaran Cicilan</h1>
            <p class="mt-3 text-lg text-gray-600 max-w-2xl mx-auto">Kelola pembayaran cicilan Anda dengan mudah dan cepat.</p>
        </div>

        <!-- Main Card -->
        <div class="relative bg-white bg-opacity-95 backdrop-blur-xl rounded-2xl shadow-2xl p-8 transition-all duration-500 hover:-translate-y-2 hover:shadow-3xl animate-fade-in">
            @if (!$loanApplication)
                <!-- Jika tidak ada pinjaman yang diajukan -->
                <div class="text-center py-12">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Belum Ada Pinjaman</h2>
                    <p class="text-gray-600 text-base mb-6 max-w-md mx-auto">
                        Anda belum memiliki ajuan pinjaman. Silakan ajukan pinjaman terlebih dahulu untuk memulai.
                    </p>
                    <a href="{{ route('loan-applications.create') }}"
                       class="relative inline-block bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-3 rounded-lg font-medium text-sm shadow-lg overflow-hidden group transition-all duration-300 hover:scale-105 hover:shadow-[0_6px_15px_rgba(59,130,246,0.4)]">
                        <span class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></span>
                        Ajukan Pinjaman Sekarang
                    </a>
                </div>
            @elseif ($loanApplication->status === 'PENDING')
                <!-- Jika pinjaman masih dalam status PENDING -->
                <div class="text-center py-12">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Ajuan Pinjaman Sedang Diproses</h2>
                    <p class="text-gray-600 text-base mb-6 max-w-md mx-auto">
                        Ajuan pinjaman Anda sedang dalam proses verifikasi. Harap tunggu hingga disetujui oleh admin.
                    </p>
                    <div class="flex justify-center">
                        <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                    </div>
                </div>
            @elseif ($loanApplication->status === 'REJECTED')
                <!-- Jika pinjaman ditolak -->
                <div class="text-center py-12">
                    <h2 class="text-2xl font-semibold text-red-600 mb-4">Pinjaman Ditolak</h2>
                    <p class="text-gray-600 text-base mb-6 max-w-md mx-auto">
                        Ajuan pinjaman Anda telah ditolak. Silakan hubungi administrator atau ajukan pinjaman baru.
                    </p>
                    <a href="{{ route('loan-applications.create') }}"
                       class="relative inline-block bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-3 rounded-lg font-medium text-sm shadow-lg overflow-hidden group transition-all duration-300 hover:scale-105 hover:shadow-[0_6px_15px_rgba(59,130,246,0.4)]">
                        <span class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></span>
                        Ajukan Pinjaman Baru
                    </a>
                </div>
            @elseif ($loanApplication->status === 'Lunas')
                <!-- Jika pinjaman sudah lunas -->
                <div class="text-center py-12">
                    <h2 class="text-2xl font-semibold text-green-600 mb-4">Semua Cicilan Lunas</h2>
                    <p class="text-gray-600 text-base mb-6 max-w-md mx-auto">
                        Terima kasih! Semua cicilan pinjaman Anda telah lunas.
                    </p>
                    <svg class="mx-auto h-12 w-12 text-green-500 mt-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <a href="{{ route('loan-applications.create') }}"
                       class="relative inline-block bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-3 rounded-lg font-medium text-sm shadow-lg overflow-hidden group transition-all duration-300 hover:scale-105 hover:shadow-[0_6px_15px_rgba(59,130,246,0.4)] mt-6">
                        <span class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></span>
                        Ajukan Pinjaman Baru
                    </a>
                </div>
            @elseif ($loanApplication->status === 'APPROVED' || $loanApplication->status === 'Belum Lunas')
                @php
                    // Calculate remaining payment
                    $remainingPayment = $loanApplication->total_payment - $loanApplication->payments->sum('amount');
                    // Determine paid installments
                    $paidInstallments = $loanApplication->payments->pluck('installment_month')->toArray();
                    $monthlyInstallment = $loanApplication->total_payment / $loanApplication->duration;
                    $startMonth = $loanApplication->start_month;
                    $startYear = $loanApplication->start_year;
                @endphp

                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800">Sisa Pembayaran</h3>
                    <p class="text-3xl font-bold text-blue-600 mt-2">
                        Rp {{ number_format($remainingPayment, 0, ',', '.') }}
                    </p>
                </div>

                @if ($remainingPayment > 0)
                    <form action="{{ route('payments.store') }}" method="POST" class="space-y-8">
                        @csrf
                        <div class="relative group">
                            <label for="payment_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Pembayaran
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-blue-500 group-hover:text-blue-600 transition-colors duration-300">
                                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </span>
                                <input
                                    type="date"
                                    name="payment_date"
                                    id="payment_date"
                                    class="pl-10 py-3 w-full rounded-lg border border-gray-200 bg-blue-50/30 text-gray-800 focus:border-blue-600 focus:ring-2 focus:ring-blue-200 focus:outline-none sm:text-sm transition-all duration-300 hover:border-blue-300 cursor-not-allowed"
                                    value="{{ now()->format('Y-m-d') }}"
                                    readonly
                                >
                            </div>
                        </div>
                        <div class="relative group">
                            <label for="installment_month" class="block text-sm font-medium text-gray-700 mb-2">
                                Pilih Bulan Cicilan
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-blue-500 group-hover:text-blue-600 transition-colors duration-300">
                                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </span>
                                <select
                                    name="installment_month"
                                    id="installment_month"
                                    class="pl-10 py-3 w-full rounded-lg border border-gray-200 bg-white/80 text-gray-800 focus:border-blue-600 focus:ring-2 focus:ring-blue-200 focus:outline-none sm:text-sm transition-all duration-300 hover:border-blue-300"
                                    required
                                >
                                    @for ($i = 0; $i < $loanApplication->duration; $i++)
                                        @php
                                            $currentMonth = ($startMonth + $i - 1) % 12 + 1;
                                            $currentYear = $startYear + intdiv($startMonth + $i - 1, 12);
                                            $monthName = \Carbon\Carbon::create()->month($currentMonth)->format('F');
                                            $installmentNumber = $i + 1;
                                            $isPaid = in_array($installmentNumber, $paidInstallments);
                                        @endphp
                                        <option value="{{ $installmentNumber }}"
                                                data-amount="{{ $monthlyInstallment }}"
                                                @if ($isPaid) disabled @endif
                                                class="{{ $isPaid ? 'text-gray-400' : 'text-gray-800' }}">
                                            {{ $monthName }} {{ $currentYear }} - Cicilan ke-{{ $installmentNumber }} (Rp {{ number_format($monthlyInstallment, 0, ',', '.') }})
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <span class="absolute hidden group-hover:block -top-8 left-1/2 transform -translate-x-1/2 bg-blue-600 text-white text-xs rounded py-1 px-2 animate-slide-up">Pilih bulan cicilan</span>
                        </div>
                        <input type="hidden" name="amount" id="amount" value="{{ $monthlyInstallment }}">
                        <button
                            type="submit"
                            class="bg-blue-600 text-white px-6 py-3 rounded-lg font-medium text-sm shadow-lg overflow-hidden group transition-all duration-300 hover:scale-105 hover:shadow-[0_6px_15px_rgba(59,130,246,0.4)] focus:outline-none focus:ring-2 focus:ring-blue-400"
                        >
                            <span class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></span>
                            <svg class="w-5 h-5 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            Bayar Cicilan Sekarang
                        </button>
                    </form>
                @else
                    <div class="text-center py-12">
                        <h3 class="text-xl font-semibold text-green-600 mb-4">Semua Cicilan Lunas</h3>
                        <p class="text-gray-600 text-base">
                            Terima kasih! Semua cicilan pinjaman Anda telah lunas.
                        </p>
                        <svg class="mx-auto h-12 w-12 text-green-500 mt-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <a href="{{ route('loan-applications.create') }}"
                           class="relative inline-block bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-3 rounded-lg font-medium text-sm shadow-lg overflow-hidden group transition-all duration-300 hover:scale-105 hover:shadow-[0_6px_15px_rgba(59,130,246,0.4)] mt-6">
                            <span class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></span>
                            Ajukan Pinjaman Baru
                        </a>
                    </div>
                @endif
            @else
                <!-- Jika status benar-benar tidak dikenali -->
                <div class="text-center py-12">
                    <h3 class="text-xl font-semibold text-red-600 mb-4">Status Tidak Valid</h3>
                    <p class="text-gray-600 text-base">
                        Status pinjaman tidak valid. Silakan hubungi administrator untuk bantuan.
                    </p>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.getElementById('installment_month')?.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const amount = selectedOption.getAttribute('data-amount');
            document.getElementById('amount').value = amount;
        });
    </script>

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
