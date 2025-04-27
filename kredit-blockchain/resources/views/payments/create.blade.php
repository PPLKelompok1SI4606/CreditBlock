@extends('layouts.app')

@section('title', 'Pembayaran Cicilan')

@php
    \Log::info('Loan Application di View:', ['loanApplication' => $loanApplication]);
@endphp

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-4xl font-bold text-sky-blue mb-10 drop-shadow-lg tracking-wide animate-fade-in">
        Pembayaran Cicilan
    </h1>
    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 mb-10 card-hover transition-all duration-300 hover:shadow-md">
        <div class="relative bg-white rounded-lg p-6 overflow-hidden">
            @if (!$loanApplication)
                <p class="text-gray-600 text-lg">
                    Anda belum memiliki ajuan pinjaman. Silakan ke menu 
                    <a href="{{ route('loan-applications.create') }}" class="text-blue-500 underline">Ajuan Pinjaman</a> terlebih dahulu.
                </p>
            @elseif ($loanApplication->status === 'PENDING')
                <p class="text-gray-600 text-lg">
                    Ajuan pinjaman Anda sedang diproses. Silakan tunggu hingga ajuan Anda disetujui.
                </p>
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

                <p class="text-gray-600 text-lg mb-4">
                    Sisa Pembayaran: 
                    <span class="font-bold text-blue-500">
                        Rp {{ number_format($remainingPayment, 0, ',', '.') }}
                    </span>
                </p>

                @if ($remainingPayment > 0)
                <form action="{{ route('payments.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="payment_date" class="block text-sm font-medium text-gray-700">
                            Tanggal Pembayaran
                        </label>
                        <input 
                            type="date" 
                            name="payment_date" 
                            id="payment_date" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                            value="{{ now()->format('Y-m-d') }}" 
                            readonly
                        >
                    </div>
                    <div class="mb-4">
                        <label for="installment_month" class="block text-sm font-medium text-gray-700">
                            Pembayaran Cicilan pada Bulan (Cicilan ke-)
                        </label>
                        <select 
                            name="installment_month" 
                            id="installment_month" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                            required
                        >
                            @php
                                $monthlyInstallment = $loanApplication->total_payment / $loanApplication->duration;
                                $startMonth = $loanApplication->start_month;
                                $startYear = $loanApplication->start_year;
                            @endphp
                            @for ($i = 0; $i < $loanApplication->duration; $i++)
                                @php
                                    $currentMonth = ($startMonth + $i - 1) % 12 + 1;
                                    $currentYear = $startYear + intdiv($startMonth + $i - 1, 12);
                                    $monthName = \Carbon\Carbon::create()->month($currentMonth)->format('F');
                                @endphp
                                <option value="{{ $i + 1 }}" data-amount="{{ $monthlyInstallment }}">
                                    {{ $monthName }} {{ $currentYear }} - Rp {{ number_format($monthlyInstallment, 0, ',', '.') }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <input type="hidden" name="amount" id="amount" value="{{ $monthlyInstallment }}">
                    <button 
                        type="submit" 
                        class="bg-blue-600 text-white px-5 py-2 rounded-lg font-medium text-sm tracking-wider leading-relaxed transition-all duration-300 hover:bg-blue-700 hover:ring-2 hover:ring-blue-200 hover:ring-opacity-50"
                    >
                        Bayar Cicilan Sekarang
                    </button>
                </form>

                <script>
                    // Update hidden input "amount" based on selected dropdown
                    document.getElementById('installment_month').addEventListener('change', function() {
                        const selectedOption = this.options[this.selectedIndex];
                        const amount = selectedOption.getAttribute('data-amount');
                        document.getElementById('amount').value = amount;
                    });
                </script>
                @else
                    <p class="text-green-600 text-lg">
                        Semua cicilan telah lunas. Terima kasih!
                    </p>
                @endif
            @else
                <p class="text-gray-600 text-lg">
                    Status pinjaman tidak dikenali. Silakan hubungi administrator.
                </p>
            @endif
        </div>
    </div>
</div>
@endsection