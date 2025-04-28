@extends('layouts.app')
@section('title', 'Riwayat Pembayaran Seluruh Pinjaman')
@section('content')

<section class="relative flex flex-col items-center py-[90px] justify-center w-full h-full px-[100px]" id="all-history">
    <div class="absolute w-full h-[400px] blur-[90px] bg-blue-100 top-50 -z-20"></div>

    <h1 class="text-[#2A9DF4] font-semibold tracking-widest text-xl hidden-animated">RIWAYAT PEMBAYARAN</h1>
    <h1 class="text-[#1167B1] font-bold text-5xl mt-2 tracking-wide hidden-animated">Riwayat Pembayaran Seluruh Pinjaman</h1>

    @forelse ($loanApplications as $loan)
    <div class="w-[1000px] py-6 px-7 border-2 border-gray-400 rounded-xl mt-10 hidden-animated accordion-section" id="accordion-loan-{{ $loan->id }}" data-expanded="false">
        <div class="header-container flex justify-between items-center">
            <h1 class="text-[#1167B1] font-bold text-xl tracking-wide">
                Pinjaman: {{ \Carbon\Carbon::create($loan->start_year, $loan->start_month)->format('F Y') }} - {{ \Carbon\Carbon::create($loan->end_year, $loan->end_month)->format('F Y') }}
            </h1>
            <img src="{{ asset('images/plus.png') }}" alt="Toggle Icon" class="cursor-pointer toggle-icon" width="24" height="24">
        </div>
        <div class="explanation mt-4 hidden">
            <table class="w-full text-gray-700 text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-900">
                        <th class="px-6 py-4 text-left font-medium tracking-wide">Pembayaran Cicilan pada Bulan (Cicilan ke-)</th>
                        <th class="px-6 py-4 text-left font-medium tracking-wide">Nominal</th>
                        <th class="px-6 py-4 text-left font-medium tracking-wide">Sisa Pembayaran</th>
                        <th class="px-6 py-4 text-left font-medium tracking-wide">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($loan->payments as $payment)
                        @php
                            $startMonth = $loan->start_month;
                            $startYear = $loan->start_year;
                            $currentMonth = ($startMonth + $payment->installment_month - 2) % 12 + 1;
                            $currentYear = $startYear + intdiv($startMonth + $payment->installment_month - 2, 12);
                            $monthName = \Carbon\Carbon::create()->month($currentMonth)->format('F');
                        @endphp
                        <tr>
                            <td class="px-6 py-4">{{ $monthName }} {{ $currentYear }} - Cicilan ke-{{ $payment->installment_month }}</td>
                            <td class="px-6 py-4 font-mono text-gray-800">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 font-mono text-gray-800">Rp {{ number_format($loan->total_payment - $loan->payments->sum('amount'), 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-block {{ $loan->total_payment - $loan->payments->sum('amount') <= 0 ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }} text-xs font-medium px-2.5 py-1 rounded-full">
                                    {{ $loan->total_payment - $loan->payments->sum('amount') <= 0 ? 'LUNAS' : 'Belum Lunas' }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@empty
    <p class="text-gray-500 mt-10">Tidak ada riwayat pembayaran.</p>
@endforelse
</section>

@endsection