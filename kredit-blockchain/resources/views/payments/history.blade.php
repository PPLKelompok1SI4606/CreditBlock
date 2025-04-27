@extends('layouts.app')
@section('title', 'Riwayat Pembayaran')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-4xl font-bold text-sky-blue mb-10 drop-shadow-lg tracking-wide animate-fade-in">Riwayat Pembayaran</h1>
    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 transition-all duration-300 card-hover hover:shadow-md">
        <div class="relative bg-white rounded-lg p-6 overflow-hidden">
            <div class="mb-4">
                <form method="GET" action="{{ route('payments.history') }}">
                    <select name="sort" id="sort" onchange="this.form.submit()" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Tanggal Terbaru</option>
                        <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Tanggal Terlama</option>
                    </select>
                </form>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-gray-700 text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-gray-900">
                            <th class="px-6 py-4 text-left rounded-tl-lg font-medium tracking-wide">Pembayaran Cicilan pada Bulan (Cicilan ke-)</th>
                            <th class="px-6 py-4 text-left font-medium tracking-wide">Nominal</th>
                            <th class="px-6 py-4 text-left font-medium tracking-wide">Sisa Pembayaran</th>
                            <th class="px-6 py-4 text-left rounded-tr-lg font-medium tracking-wide">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($payments as $payment)
                        @php
                            $loan = $payment->loan;

                            // Ambil bulan dan tahun berdasarkan installment_month
                            $startMonth = $loan->start_month;
                            $startYear = $loan->start_year;
                            $currentMonth = ($startMonth + $payment->installment_month - 2) % 12 + 1;
                            $currentYear = $startYear + intdiv($startMonth + $payment->installment_month - 2, 12);
                            $monthName = \Carbon\Carbon::create()->month($currentMonth)->format('F');
                        @endphp
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-all duration-200">
                            <td class="px-6 py-4">{{ $monthName }} {{ $currentYear }} - Cicilan ke-{{ $payment->installment_month }}</td>
                            <td class="px-6 py-4 font-mono text-gray-800">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 font-mono text-gray-800">Rp {{ number_format($loan->total_payment - $loan->payments->sum('amount'), 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-block {{ $loan->total_payment - $loan->payments->sum('amount') <= 0 ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }} text-xs font-medium px-2.5 py-1 rounded-full">
                                    {{ $loan->total_payment - $loan->payments->sum('amount') <= 0 ? 'LUNAS' : 'Belum Lunas' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">Tidak ada riwayat pembayaran.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection