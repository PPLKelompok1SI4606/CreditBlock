@extends('layouts.app')

@section('title', 'Riwayat Peminjaman')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
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
            <div class="relative overflow-x-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                <!-- Scroll Shadows -->
                <div class="absolute inset-y-0 left-0 w-4 bg-gradient-to-r from-gray-100 to-transparent pointer-events-none z-10"></div>
                <div class="absolute inset-y-0 right-0 w-4 bg-gradient-to-l from-gray-100 to-transparent pointer-events-none z-10"></div>

                <table class="w-full text-left text-sm font-medium text-gray-900 table-auto">
                    <thead>
                        <tr class="bg-gray-50 text-gray-700 uppercase text-xs tracking-wider sticky top-0 z-10">
                            <th class="py-4 px-6 rounded-tl-lg min-w-[140px]">Mulai Peminjaman</th>
                            <th class="py-4 px-6 min-w-[140px]">Akhir Peminjaman</th>
                            <th class="py-4 px-6 min-w-[180px]">Nominal Peminjaman</th>
                            <th class="py-4 px-6 min-w-[100px]">Durasi</th>
                            <th class="py-4 px-6 min-w-[120px]">Sisa Bulan</th>
                            <th class="py-4 px-6 min-w-[100px]">Bunga</th>
                            <th class="py-4 px-6 rounded-tr-lg min-w-[120px]">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($loanApplications as $loan)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="py-4 px-6 font-medium whitespace-nowrap">
                                    {{ \Carbon\Carbon::create($loan->start_year, $loan->start_month, 1)->translatedFormat('F Y') }}
                                </td>
                                <td class="py-4 px-6 whitespace-nowrap">
                                    {{ \Carbon\Carbon::create($loan->end_year, $loan->end_month, 1)->translatedFormat('F Y') }}
                                </td>
                                <td class="py-4 px-6 whitespace-nowrap">
                                    Rp {{ number_format($loan->amount, 0, ',', '.') }}
                                </td>
                                <td class="py-4 px-6 whitespace-nowrap">{{ $loan->duration }} Bulan</td>
                                <td class="py-4 px-6 whitespace-nowrap">
                                    @php
                                        $endDate = \Carbon\Carbon::create($loan->end_year, $loan->end_month, 1);
                                        $now = \Carbon\Carbon::now();
                                        $remainingMonths = $now->greaterThan($endDate) ? 0 : $now->diffInMonths($endDate);
                                    @endphp
                                    {{ round($remainingMonths) }} Bulan
                                </td>
                                <td class="py-4 px-6 whitespace-nowrap">{{ number_format($loan->interest_rate, 1) }}%</td>
                                <td class="py-4 px-6">
                                    @php
                                        $statusLabels = [
                                            'PENDING' => 'Menunggu',
                                            'APPROVED' => 'Disetujui',
                                            'REJECTED' => 'Ditolak',
                                            'Belum Lunas' => 'Belum Lunas',
                                            'Lunas' => 'Lunas'
                                        ];
                                        $statusStyles = [
                                            'PENDING' => 'bg-yellow-100 text-yellow-800',
                                            'APPROVED' => 'bg-green-100 text-green-800',
                                            'REJECTED' => 'bg-red-100 text-red-800',
                                            'Belum Lunas' => 'bg-orange-100 text-orange-800',
                                            'Lunas' => 'bg-blue-100 text-blue-800'
                                        ];
                                        $status = $statusLabels[$loan->status] ?? $loan->status;
                                        $style = $statusStyles[$loan->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="{{ $style }} px-3 py-1 rounded-full text-xs font-medium whitespace-nowrap">
                                        {{ $status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-6 px-6 text-center text-gray-500 text-sm">
                                    Tidak ada riwayat peminjaman.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tailwind Scrollbar Styles -->
    <style>
        .scrollbar-thin {
            scrollbar-width: thin;
        }
        .scrollbar-thin::-webkit-scrollbar {
            height: 8px;
        }
        .scrollbar-thin::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 4px;
        }
        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }
    </style>
@endsection
