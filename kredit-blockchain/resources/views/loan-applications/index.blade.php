@extends('layouts.app')

@section('title', 'Riwayat Peminjaman')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Riwayat Peminjaman</h1>
        </div>

        <!-- Table Card -->
        <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-lg transition-all duration-300">
            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-800 rounded-lg flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Error Message -->
            @if (session('error'))
                <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-800 rounded-lg flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700">
                            <th class="py-3 px-4 rounded-tl-lg">Bulan Mulai Peminjaman</th>
                            <th class="py-3 px-4">Durasi Peminjaman</th>
                            <th class="py-3 px-4">Sisa Bulan</th>
                            <th class="py-3 px-4 rounded-tr-lg">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($loanApplications as $loan)
                            <tr class="border-t border-gray-200 hover:bg-gray-50 transition-colors duration-200">
                                <td class="py-3 px-4">{{ \Carbon\Carbon::parse($loan->start_date)->translatedFormat('F Y') }}</td>
                                <td class="py-3 px-4">{{ $loan->duration }} Bulan</td>
                                <td class="py-3 px-4">{{ $loan->remaining_months }} Bulan</td>
                                <td class="py-3 px-4">
                                    <span class="{{ $loan->status === 'Lunas' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} px-3 py-1 rounded-full text-sm font-medium">
                                        {{ $loan->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-4 px-4 text-center text-gray-500">
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