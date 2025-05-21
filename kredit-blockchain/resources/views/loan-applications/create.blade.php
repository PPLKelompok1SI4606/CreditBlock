@extends('layouts.app')

@section('title', 'Ajukan Pinjaman')

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
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-800 tracking-tight">Ajukan Pinjaman Baru</h1>
            <p class="mt-3 text-lg text-gray-600 max-w-2xl mx-auto">Dapatkan dana yang Anda butuhkan dengan proses cepat dan mudah.</p>
            <a href="{{ route('dashboard') }}"
               class="inline-block mt-4 text-blue-600 hover:text-blue-800 text-sm font-medium relative group">
                Kembali ke Dashboard
                <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
            </a>
        </div>

        <!-- Form Card -->
        <div class="relative bg-white bg-opacity-95 backdrop-blur-xl rounded-2xl shadow-2xl p-8 transition-all duration-500 hover:-translate-y-2 hover:shadow-3xl animate-fade-in">
            <!-- Unpaid Loan Message -->
            @if (isset($hasUnpaidLoan) && $hasUnpaidLoan)
                <div class="mb-8 p-4 bg-red-100 border-l-4 border-red-500 text-red-800 rounded-xl flex items-center animate-pulse">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span>Pinjaman Anda belum lunas. Harap lunasi terlebih dahulu sebelum mengajukan pinjaman baru.</span>
                </div>
            @endif

            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-8 p-4 bg-blue-100 border-l-4 border-blue-500 text-blue-800 rounded-xl flex items-center animate-pulse">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Error Message -->
            @if (session('error'))
                <div class="mb-8 p-4 bg-red-100 border-l-4 border-red-500 text-red-800 rounded-xl flex items-center animate-pulse">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <form id="loanForm" action="{{ route('loan-applications.store') }}" method="POST" enctype="multipart/form-data" @if (isset($hasUnpaidLoan) && $hasUnpaidLoan) class="pointer-events-none opacity-50" @endif>
                @csrf
                <div class="space-y-8">
                    <!-- Amount -->
                    <div class="relative group">
                        <label for="amount_display" class="block text-sm font-medium text-gray-700 mb-2">Jumlah Pinjaman (IDR)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-blue-500 group-hover:text-blue-600 transition-colors duration-300">
                                <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </span>
                            <input type="text" name="amount_display" id="amount_display" required
                                   class="pl-10 pr-12 py-3 w-full rounded-lg border border-gray-200 bg-white/80 text-gray-800 placeholder-gray-400 focus:border-blue-600 focus:ring-2 focus:ring-blue-200 focus:outline-none sm:text-sm transition-all duration-300 hover:border-blue-300"
                                   placeholder="Rp5.000.000">
                            <input type="hidden" name="amount" id="amount">
                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-blue-500 text-xs font-medium">IDR</span>
                        </div>
                        <span class="absolute hidden group-hover:block -top-8 left-1/2 transform -translate-x-1/2 bg-blue-600 text-white text-xs rounded py-1 px-2 animate-slide-up">Masukkan jumlah dalam Rupiah</span>
                        @error('amount')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Duration -->
                    <div class="relative group">
                        <label for="duration" class="block text-sm font-medium text-gray-700 mb-2">Jangka Waktu (Bulan)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-blue-500 group-hover:text-blue-600 transition-colors duration-300">
                                <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </span>
                            <input type="number" name="duration" id="duration" required
                                   class="pl-10 pr-16 py-3 w-full rounded-lg border border-gray-200 bg-white/80 text-gray-800 placeholder-gray-400 focus:border-blue-600 focus:ring-2 focus:ring-blue-200 focus:outline-none sm:text-sm transition-all duration-300 hover:border-blue-300"
                                   placeholder="12" min="1" max="60">
                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-blue-500 text-xs font-medium">Bulan</span>
                        </div>
                        <span class="absolute hidden group-hover:block -top-8 left-1/2 transform -translate-x-1/2 bg-blue-600 text-white text-xs rounded py-1 px-2 animate-slide-up">1 hingga 60 bulan</span>
                        @error('duration')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Interest Rate -->
                    <div class="relative group">
                        <label for="interest_rate" class="block text-sm font-medium text-gray-700 mb-2">Suku Bunga (% per tahun)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-blue-500 group-hover:text-blue-600 transition-colors duration-300">
                                <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                            </span>
                            <input type="number" name="interest_rate" id="interest_rate" readonly
                                   class="pl-10 pr-12 py-3 w-full rounded-lg border border-gray-200 bg-blue-50/30 text-gray-800 placeholder-gray-400 focus:border-blue-600 focus:ring-2 focus:ring-blue-200 focus:outline-none sm:text-sm transition-all duration-300 hover:border-blue-300"
                                   value="5">
                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-blue-500 text-xs font-medium">%</span>
                        </div>
                        <span class="absolute hidden group-hover:block -top-8 left-1/2 transform -translate-x-1/2 bg-blue-600 text-white text-xs rounded py-1 px-2 animate-slide-up">Bunga otomatis berdasarkan durasi</span>
                        @error('interest_rate')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Start and End Dates -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Start Date -->
                        <div class="relative group">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mulai Pinjaman</label>
                            <div class="flex space-x-4">
                                <div class="flex-1">
                                    <select name="start_month" id="start_month" required
                                            class="py-3 w-full rounded-lg border border-gray-200 bg-white/80 text-gray-800 focus:border-blue-600 focus:ring-2 focus:ring-blue-200 focus:outline-none sm:text-sm transition-all duration-300 hover:border-blue-300">
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}">{{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}</option>
                                        @endfor
                                    </select>
                                    @error('start_month')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="flex-1">
                                    <select name="start_year" id="start_year" required
                                            class="py-3 w-full rounded-lg border border-gray-200 bg-white/80 text-gray-800 focus:border-blue-600 focus:ring-2 focus:ring-blue-200 focus:outline-none sm:text-sm transition-all duration-300 hover:border-blue-300">
                                        @for ($i = 2025; $i <= 2030; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                    @error('start_year')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <span class="absolute hidden group-hover:block -top-8 left-1/2 transform -translate-x-1/2 bg-blue-600 text-white text-xs rounded py-1 px-2 animate-slide-up">Pilih tanggal mulai</span>
                        </div>

                        <!-- End Date -->
                        <div class="relative group">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Selesai Pinjaman</label>
                            <div class="flex space-x-4">
                                <div class="flex-1">
                                    <select name="end_month" id="end_month" required readonly
                                            class="py-3 w-full rounded-lg border border-gray-200 bg-blue-50/30 text-gray-800 focus:border-blue-600 focus:ring-2 focus:ring-blue-200 focus:outline-none sm:text-sm transition-all duration-300 hover:border-blue-300">
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}">{{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}</option>
                                        @endfor
                                    </select>
                                    @error('end_month')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="flex-1">
                                    <select name="end_year" id="end_year" required readonly
                                            class="py-3 w-full rounded-lg border border-gray-200 bg-blue-50/30 text-gray-800 focus:border-blue-600 focus:ring-2 focus:ring-blue-200 focus:outline-none sm:text-sm transition-all duration-300 hover:border-blue-300">
                                        @for ($i = 2025; $i <= 2030; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                    @error('end_year')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <span class="absolute hidden group-hover:block -top-8 left-1/2 transform -translate-x-1/2 bg-blue-600 text-white text-xs rounded py-1 px-2 animate-slide-up">Diisi otomatis</span>
                        </div>
                    </div>

                    <!-- Document -->
                    <div class="relative group">
                        <label for="document" class="block text-sm font-medium text-gray-700 mb-2">Dokumen Pendukung</label>
                        <div class="relative border-2 border-dashed border-gray-200 rounded-lg p-4 hover:border-blue-600 transition-all duration-300">
                            <input type="file" name="document" id="document" required
                                   accept=".pdf,.jpg,.png"
                                   class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-600 file:text-white file:font-medium file:hover:bg-blue-700 file:transition-colors file:cursor-pointer">
                            <p class="mt-2 text-xs text-gray-500">Unggah slip gaji atau dokumen lainnya (PDF, JPG, PNG, maks 2MB)</p>
                        </div>
                        <span class="absolute hidden group-hover:block -top-8 left-1/2 transform -translate-x-1/2 bg-blue-600 text-white text-xs rounded py-1 px-2 animate-slide-up">Maksimum 2MB</span>
                        @error('document')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-8 flex justify-end">
                        <button type="submit"
                                class="relative bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-3 rounded-lg font-medium text-sm shadow-lg overflow-hidden group transition-all duration-300 hover:scale-105 hover:shadow-[0_6px_15px_rgba(59,130,246,0.4)] focus:outline-none focus:ring-2 focus:ring-blue-400">
                            <span class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></span>
                            <svg class="w-5 h-5 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            Ajukan Pinjaman
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Format Rupiah
        const amountDisplay = document.getElementById('amount_display');
        const amountHidden = document.getElementById('amount');

        amountDisplay.addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^0-9]/g, '');
            if (value) {
                value = parseInt(value);
                amountHidden.value = value;
                e.target.value = 'Rp' + value.toLocaleString('id-ID');
            } else {
                amountHidden.value = '';
                e.target.value = '';
            }
        });

        // Otomatis hitung bunga dan tanggal selesai berdasarkan durasi dan tanggal mulai
        const durationInput = document.getElementById('duration');
        const interestRateInput = document.getElementById('interest_rate');
        const startMonthInput = document.getElementById('start_month');
        const startYearInput = document.getElementById('start_year');
        const endMonthInput = document.getElementById('end_month');
        const endYearInput = document.getElementById('end_year');

        function updateEndDate() {
            const duration = parseInt(durationInput.value);
            const startMonth = parseInt(startMonthInput.value);
            const startYear = parseInt(startYearInput.value);

            if (duration && startMonth && startYear) {
                let totalBulan = startMonth + duration - 1;
                let endYear = startYear + Math.floor(totalBulan / 12);
                let endMonth = (totalBulan % 12) || 12;

                endMonthInput.value = endMonth;
                endYearInput.value = endYear;
            } else {
                endMonthInput.value = '';
                endYearInput.value = '';
            }
        }

        function updateInterestRate() {
            const duration = parseInt(durationInput.value);
            if (duration >= 1 && duration <= 6) {
                interestRateInput.value = 5;
            } else if (duration > 6) {
                interestRateInput.value = 10;
            } else {
                interestRateInput.value = 5;
            }
        }

        durationInput.addEventListener('input', function() {
            updateInterestRate();
            updateEndDate();
        });

        startMonthInput.addEventListener('change', updateEndDate);
        startYearInput.addEventListener('change', updateEndDate);

        updateEndDate();
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
