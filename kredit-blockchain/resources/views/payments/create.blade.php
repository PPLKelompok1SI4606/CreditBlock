@extends('layouts.app')

@section('title', 'Pembayaran Cicilan')

@php
    \Log::info('Loan Application di View:', ['loanApplication' => $loanApplication]);
@endphp

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-sky-600 mb-8 drop-shadow-md tracking-tight animate-fade-in text-center">
        Pembayaran Cicilan
    </h1>
    <div class="bg-white border border-gray-200 rounded-2xl shadow-lg p-8 transition-all duration-300 hover:shadow-xl">
        @if (!$loanApplication)
            <!-- Jika tidak ada pinjaman yang diajukan -->
            <div class="text-center py-12">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Belum Ada Pinjaman</h2>
                <p class="text-gray-600 text-base mb-6 max-w-md mx-auto">
                    Anda belum memiliki ajuan pinjaman. Silakan ajukan pinjaman terlebih dahulu untuk memulai.
                </p>
                <a href="{{ route('loan-applications.create') }}" 
                   class="inline-block bg-sky-600 text-white px-6 py-3 rounded-lg font-medium text-sm tracking-wide transition-all duration-300 hover:bg-sky-700 hover:ring-2 hover:ring-sky-200">
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
                    <svg class="animate-spin h-8 w-8 text-sky-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                </div>
            </div>
        @elseif ($loanApplication->status === 'APPROVED')
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
                <p class="text-3xl font-bold text-sky-600 mt-2">
                    Rp {{ number_format($remainingPayment, 0, ',', '.') }}
                </p>
            </div>

            @if ($remainingPayment > 0)
                <form action="{{ route('payments.store') }}" method="POST" class="space-y-8">
                    @csrf
                    <div>
                        <label for="payment_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Pembayaran
                        </label>
                        <input 
                            type="date" 
                            name="payment_date" 
                            id="payment_date" 
                            class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 text-lg py-4 px-5 bg-gray-100 cursor-not-allowed" 
                            value="{{ now()->format('Y-m-d') }}" 
                            readonly
                        >
                    </div>
                    <div>
                        <label for="installment_month" class="block text-sm font-medium text-gray-700 mb-2">
                            Pilih Bulan Cicilan
                        </label>
                        <select 
                            name="installment_month" 
                            id="installment_month" 
                            class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 text-lg py-4 px-5" 
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
                    <input type="hidden" name="amount" id="amount" value="{{ $monthlyInstallment }}">
                    <button 
                        type="submit" 
                        class="w-full bg-sky-600 text-white px-6 py-4 rounded-xl font-semibold text-base tracking-wide transition-all duration-300 hover:bg-sky-700 hover:ring-2 hover:ring-sky-200"
                    >
                        Bayar Cicilan Sekarang
                    </button>
                </form>

                <script>
                    document.getElementById('installment_month').addEventListener('change', function() {
                        const selectedOption = this.options[this.selectedIndex];
                        const amount = selectedOption.getAttribute('data-amount');
                        document.getElementById('amount').value = amount;
                    });
                </script>
            @else
                <div class="text-center py-12">
                    <h3 class="text-xl font-semibold text-green-600 mb-4">Semua Cicilan Lunas</h3>
                    <p class="text-gray-600 text-base">
                        Terima kasih! Semua cicilan pinjaman Anda telah lunas.
                    </p>
                    <svg class="mx-auto h-12 w-12 text-green-500 mt-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            @endif
        @else
            <div class="text-center py-12">
                <h3 class="text-xl font-semibold text-red-600 mb-4">Status Tidak Dikenali</h3>
                <p class="text-gray-600 text-base">
                    Status pinjaman tidak dikenali. Silakan hubungi administrator untuk bantuan.
                </p>
            </div>
        @endif
    </div>
</div>
@endsection