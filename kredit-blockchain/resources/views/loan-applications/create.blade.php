@extends('layouts.app')

@section('title', 'Ajukan Pinjaman')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Ajukan Pinjaman Baru</h1>
            <a href="{{ route('dashboard') }}"
               class="text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors duration-200">
                Kembali ke Dashboard
            </a>
        </div>

        <!-- Form Card -->
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

            <form id="loanForm" action="{{ route('loan-applications.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-6">
                    <!-- Amount -->
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                            Jumlah Pinjaman (IDR)
                        </label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 group-hover:text-blue-600 transition-colors duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </span>
                            <input type="text" name="amount_display" id="amount_display" required
                                   class="pl-10 pr-12 py-3 w-full rounded-lg border border-gray-300 bg-white text-gray-900 placeholder-gray-400 focus:border-blue-600 focus:ring-2 focus:ring-blue-200 focus:outline-none sm:text-sm transition-all duration-200 hover:border-gray-400"
                                   placeholder="Rp5.000.000">
                            <input type="hidden" name="amount" id="amount">
                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 text-xs font-medium">
                                IDR
                            </span>
                        </div>
                        @error('amount')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Duration -->
                    <div>
                        <label for="duration" class="block text-sm font-medium text-gray-700 mb-2">
                            Jangka Waktu (Bulan)
                        </label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 group-hover:text-blue-600 transition-colors duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </span>
                            <input type="number" name="duration" id="duration" required
                                   class="pl-10 pr-16 py-3 w-full rounded-lg border border-gray-300 bg-white text-gray-900 placeholder-gray-400 focus:border-blue-600 focus:ring-2 focus:ring-blue-200 focus:outline-none sm:text-sm transition-all duration-200 hover:border-gray-400"
                                   placeholder="12" min="1" max="60">
                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 text-xs font-medium">
                                Bulan
                            </span>
                        </div>
                        @error('duration')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Interest Rate -->
                    <div>
                        <label for="interest_rate" class="block text-sm font-medium text-gray-700 mb-2">
                            Suku Bunga (% per tahun)
                        </label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 group-hover:text-blue-600 transition-colors duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                            </span>
                            <input type="number" name="interest_rate" id="interest_rate" readonly
                                   class="pl-10 pr-12 py-3 w-full rounded-lg border border-gray-300 bg-gray-100 text-gray-900 placeholder-gray-400 focus:border-blue-600 focus:ring-2 focus:ring-blue-200 focus:outline-none sm:text-sm transition-all duration-200 hover:border-gray-400"
                                   value="5">
                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 text-xs font-medium">
                                %
                            </span>
                        </div>
                        @error('interest_rate')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Start Date -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="start_month" class="block text-sm font-medium text-gray-700 mb-2">
                                Mulai Pinjaman (Bulan)
                            </label>
                            <select name="start_month" id="start_month" required
                                    class="py-3 w-full rounded-lg border border-gray-300 bg-white text-gray-900 focus:border-blue-600 focus:ring-2 focus:ring-blue-200 focus:outline-none sm:text-sm transition-all duration-200 hover:border-gray-400">
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}">{{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}</option>
                                @endfor
                            </select>
                            @error('start_month')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="start_year" class="block text-sm font-medium text-gray-700 mb-2">
                                Mulai Pinjaman (Tahun)
                            </label>
                            <select name="start_year" id="start_year" required
                                    class="py-3 w-full rounded-lg border border-gray-300 bg-white text-gray-900 focus:border-blue-600 focus:ring-2 focus:ring-blue-200 focus:outline-none sm:text-sm transition-all duration-200 hover:border-gray-400">
                                @for ($i = 2025; $i <= 2030; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            @error('start_year')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- End Date -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="end_month" class="block text-sm font-medium text-gray-700 mb-2">
                                Selesai Pinjaman (Bulan)
                            </label>
                            <select name="end_month" id="end_month" required readonly
                                    class="py-3 w-full rounded-lg border border-gray-300 bg-gray-100 text-gray-900 focus:border-blue-600 focus:ring-2 focus:ring-blue-200 focus:outline-none sm:text-sm transition-all duration-200 hover:border-gray-400">
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}">{{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}</option>
                                @endfor
                            </select>
                            @error('end_month')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="end_year" class="block text-sm font-medium text-gray-700 mb-2">
                                Selesai Pinjaman (Tahun)
                            </label>
                            <select name="end_year" id="end_year" required readonly
                                    class="py-3 w-full rounded-lg border border-gray-300 bg-gray-100 text-gray-900 focus:border-blue-600 focus:ring-2 focus:ring-blue-200 focus:outline-none sm:text-sm transition-all duration-200 hover:border-gray-400">
                                @for ($i = 2025; $i <= 2030; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            @error('end_year')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Document -->
                    <div>
                        <label for="document" class="block text-sm font-medium text-gray-700 mb-2">
                            Dokumen Pendukung
                        </label>
                        <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-4 hover:border-blue-600 transition-all duration-200">
                            <input type="file" name="document" id="document" required
                                   accept=".pdf,.jpg,.png"
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-600 file:text-white file:font-medium file:hover:bg-blue-700 file:transition-colors file:cursor-pointer">
                            <p class="mt-2 text-xs text-gray-500">Unggah slip gaji atau dokumen lainnya (PDF, JPG, PNG, maks 2MB)</p>
                        </div>
                        @error('document')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-8 flex justify-end">
                    <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-blue-300">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        Ajukan Pinjaman
                    </button>
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
                // Hitung tanggal selesai
                let totalBulan = startMonth + duration - 1; // Kurang 1 karena bulan mulai dihitung
                let endYear = startYear + Math.floor(totalBulan / 12);
                let endMonth = (totalBulan % 12) || 12; // Kalo sisa 0, jadi 12

                // Update field tanggal selesai
                endMonthInput.value = endMonth;
                endYearInput.value = endYear;
            } else {
                // Reset kalo input ga lengkap
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

        durationInput.addEventListener('input', function(e) {
            updateInterestRate();
            updateEndDate();
        });

        startMonthInput.addEventListener('change', updateEndDate);
        startYearInput.addEventListener('change', updateEndDate);

        // Panggil updateEndDate saat halaman dimuat untuk inisialisasi
        updateEndDate();
    </script>
@endsection
