@extends('layouts.app')
@section('title', 'Riwayat Pembayaran')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-4xl font-bold text-sky-blue mb-10 drop-shadow-lg tracking-wide animate-fade-in">Riwayat Pembayaran</h1>
    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 transition-all duration-300 card-hover hover:shadow-md">
        <div class="relative bg-white rounded-lg p-6 overflow-hidden">
            <div class="mb-4 flex justify-between items-center">
                <!-- Tombol Riwayat Pembayaran Seluruh Pinjaman -->
                <!--<a href="{{ route('payments.all-history') }}" 
                   class="bg-blue-600 text-white px-5 py-2 rounded-lg font-medium text-sm tracking-wider leading-relaxed transition-all duration-300 hover:bg-blue-700 hover:ring-2 hover:ring-blue-200 hover:ring-opacity-50">
                    Riwayat Pembayaran Seluruh Pinjaman
                </a>-->

                <!-- Dropdown untuk pengurutan -->
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
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-all duration-200">
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
</div>
@endsection