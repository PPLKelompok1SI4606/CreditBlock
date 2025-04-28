@extends('layouts.app')

@section('title', 'Riwayat Peminjaman')

@section('content')
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">Riwayat Peminjaman</h1>
        </div>

        <!-- Table Card -->
        <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-lg transition-all duration-300 hover:shadow-xl border border-gray-100">
            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg flex items-center transition-all duration-300">
                    <svg class="w-5 h-5 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Error Message -->
            @if (session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg flex items-center transition-all duration-300">
                    <svg class="w-5 h-5 mr-3 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Table -->
            <div class="overflow-x-auto rounded-lg">
                <table class="w-full text-left text-sm font-medium text-gray-900">
                    <thead>
                        <tr class="bg-gray-50 text-gray-700 uppercase text-xs tracking-wider">
                            <th class="py-4 px-6 rounded-tl-lg">Mulai Peminjaman</th>
                            <th class="py-4 px-6">Akhir Peminjaman</th>
                            <th class="py-4 px-6">Durasi</th>
                            <th class="py-4 px-6">Sisa Bulan</th>
                            <th class="py-4 px-6">Bunga</th>
                            <th class="py-4 px-6 rounded-tr-lg">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($loanApplications as $loan)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="py-4 px-6 font-medium">
                                    {{ \Carbon\Carbon::create($loan->start_year, $loan->start_month, 1)->translatedFormat('F Y') }}
                                </td>
                                <td class="py-4 px-6">
                                    {{ \Carbon\Carbon::create($loan->end_year, $loan->end_month, 1)->translatedFormat('F Y') }}
                                </td>
                                <td class="py-4 px-6">{{ $loan->duration }} Bulan</td>
                                <td class="py-4 px-6">
                                    @php
                                        $endDate = \Carbon\Carbon::create($loan->end_year, $loan->end_month, 1);
                                        $now = \Carbon\Carbon::now();
                                        $remainingMonths = $now->greaterThan($endDate) ? 0 : $now->diffInMonths($endDate);
                                    @endphp
                                    {{ round($remainingMonths) }} Bulan
                                </td>
                                <td class="py-4 px-6">{{ number_format($loan->interest_rate, 1) }}%</td>
                                <td class="py-4 px-6">
                                    @php
                                        $statusLabels = [
                                            'PENDING' => 'Menunggu',
                                            'APPROVED' => 'Disetujui',
                                            'REJECTED' => 'Ditolak'
                                        ];
                                        $statusStyles = [
                                            'PENDING' => 'bg-yellow-100 text-yellow-800',
                                            'APPROVED' => 'bg-green-100 text-green-800',
                                            'REJECTED' => 'bg-red-100 text-red-800'
                                        ];
                                        $status = $statusLabels[$loan->status] ?? $loan->status;
                                        $style = $statusStyles[$loan->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="{{ $style }} px-3 py-1 rounded-full text-xs font-medium">
                                        {{ $status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-6 px-6 text-center text-gray-500 text-sm">
                                    Tidak ada riwayat peminjaman.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
