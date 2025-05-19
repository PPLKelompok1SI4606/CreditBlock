@extends('layouts.app')

@section('title', 'Riwayat Peminjaman')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8 animate-fade-in-up">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-blue-800 tracking-tight">Riwayat Peminjaman</h1>
        </div>

        <!-- Table Card -->
        <div
            class="relative bg-white bg-opacity-20 backdrop-blur-lg border border-blue-100/50 rounded-3xl shadow-xl p-6 sm:p-8 transition-all duration-500 hover:shadow-[0_8px_25px_rgba(42,157,244,0.2)] hover:-translate-y-1 animate-fade-in-up">
            <div
                class="relative rounded-2xl p-6 bg-gradient-to-br from-blue-50/50 to-blue-100/30 text-blue-600 overflow-hidden">
                <!-- Success Message -->
                @if (session('success'))
                    <div
                        class="mb-6 p-4 bg-blue-100 border-l-4 border-blue-500 text-blue-800 rounded-xl flex items-center animate-pulse">
                        <svg class="w-5 h-5 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                @endif

                <!-- Error Message -->
                @if (session('error'))
                    <div
                        class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-800 rounded-xl flex items-center animate-pulse">
                        <svg class="w-5 h-5 mr-3 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                        <span class="text-sm font-medium">{{ session('error') }}</span>
                    </div>
                @endif

                <!-- Table -->
                <div class="relative overflow-x-auto scrollbar-thin scrollbar-thumb-blue-300 scrollbar-track-blue-100">
                    <!-- Scroll Shadows -->
                    <div
                        class="absolute inset-y-0 left-0 w-4 bg-gradient-to-r from-blue-100/50 to-transparent pointer-events-none z-10">
                    </div>
                    <div
                        class="absolute inset-y-0 right-0 w-4 bg-gradient-to-l from-blue-100/50 to-transparent pointer-events-none z-10">
                    </div>
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('loan.exportPdf') }}" target="_blank"
                            class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-lg shadow hover:bg-red-700 transition-all">
                            Cetak PDF
                        </a>
                    </div>
                    <table class="w-full text-left text-sm font-medium text-blue-600 table-auto">
                        <thead>
                            <tr class="bg-blue-50/50 text-blue-800 uppercase text-xs tracking-wider sticky top-0 z-10">
                                <th class="py-4 px-6 rounded-tl-lg min-w-[140px]">Mulai Peminjaman</th>
                                <th class="py-4 px-6 min-w-[140px]">Akhir Peminjaman</th>
                                <th class="py-4 px-6 min-w-[180px]">Nominal Peminjaman</th>
                                <th class="py-4 px-6 min-w-[100px]">Durasi</th>
                                <th class="py-4 px-6 min-w-[120px]">Sisa Bulan</th>
                                <th class="py-4 px-6 min-w-[100px]">Bunga</th>
                                <th class="py-4 px-6 rounded-tr-lg min-w-[120px]">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-blue-100/50">
                            @forelse ($loanApplications as $loan)
                                <tr class="hover:bg-blue-50/30 transition-all duration-200">
                                    <td class="py-4 px-6 font-medium whitespace-nowrap">
                                        {{ \Carbon\Carbon::create($loan->start_year, $loan->start_month, 1)->translatedFormat('F Y') }}
                                    </td>
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        {{ \Carbon\Carbon::create($loan->end_year, $loan->end_month, 1)->translatedFormat('F Y') }}
                                    </td>
                                    <td class="py-4 px-6 whitespace-nowrap font-mono">
                                        Rp {{ number_format($loan->amount, 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 px-6 whitespace-nowrap">{{ $loan->duration }} Bulan</td>
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        @php
                                            $endDate = \Carbon\Carbon::create($loan->end_year, $loan->end_month, 1);
                                            $now = \Carbon\Carbon::now();
                                            $remainingMonths = $now->greaterThan($endDate)
                                                ? 0
                                                : $now->diffInMonths($endDate);
                                        @endphp
                                        {{ round($remainingMonths) }} Bulan
                                    </td>
                                    <td class="py-4 px-6 whitespace-nowrap">{{ number_format($loan->interest_rate, 1) }}%
                                    </td>
                                    <td class="py-4 px-6 group relative">
                                        @php
                                            $statusLabels = [
                                                'PENDING' => 'Menunggu',
                                                'APPROVED' => 'Disetujui',
                                                'REJECTED' => 'Ditolak',
                                                'Belum Lunas' => 'Belum Lunas',
                                                'Lunas' => 'Lunas',
                                            ];
                                            $statusStyles = [
                                                'PENDING' => 'bg-yellow-100 text-yellow-800',
                                                'APPROVED' => 'bg-blue-100 text-blue-800 animate-pulse',
                                                'REJECTED' => 'bg-red-100 text-red-800',
                                                'Belum Lunas' => 'bg-orange-100 text-orange-800',
                                                'Lunas' => 'bg-blue-100 text-blue-800 animate-pulse',
                                            ];
                                            $statusTooltips = [
                                                'PENDING' => 'Menunggu persetujuan admin',
                                                'APPROVED' => 'Pinjaman disetujui',
                                                'REJECTED' => 'Pinjaman ditolak',
                                                'Belum Lunas' => 'Pinjaman belum lunas',
                                                'Lunas' => 'Pinjaman telah lunas',
                                            ];
                                            $status = $statusLabels[$loan->status] ?? $loan->status;
                                            $style = $statusStyles[$loan->status] ?? 'bg-gray-100 text-gray-800';
                                            $tooltip = $statusTooltips[$loan->status] ?? $status;
                                        @endphp
                                        <span
                                            class="{{ $style }} px-3 py-1 rounded-full text-xs font-medium whitespace-nowrap shadow-[0_2px_5px_rgba(42,157,244,0.2)]">
                                            {{ $status }}
                                        </span>
                                        <span
                                            class="absolute hidden group-hover:block -top-8 left-1/2 transform -translate-x-1/2 bg-blue-600 text-white text-xs rounded py-1 px-2 animate-slide-up">
                                            {{ $tooltip }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-6 px-6 text-center text-blue-600 text-sm">
                                        Tidak ada riwayat peminjaman.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
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
            background: rgba(42, 157, 244, 0.1);
            border-radius: 4px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #2A9DF4;
            border-radius: 4px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: #2563EB;
        }
    </style>
@endsection
