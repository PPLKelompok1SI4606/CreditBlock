@extends('layouts.app')

@section('title', 'Ajukan Pinjaman')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Ajukan Pinjaman Baru</h1>
            <a href="{{ route('dashboard') }}"
               class="text-sm font-medium text-blue-primary hover:text-blue-600 transition-colors">
                Kembali ke Dashboard
            </a>
        </div>

        <div class="bg-white p-8 rounded-xl shadow-lg card-hover transition-all duration-300">
            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-400 text-green-700 rounded-lg flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Error Message -->
            @if (session('error'))
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-400 text-red-700 rounded-lg flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <form id="loanForm" action="{{ route('loan-applications.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="blockchain_loan_id" id="blockchain_loan_id">
                <div class="space-y-6">
                    <!-- Amount -->
                    <div>
                        <label for="amount" class="block text-sm font-semibold text-gray-700 mb-2">
                            Jumlah Pinjaman (IDR)
                        </label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 group-hover:text-blue-primary transition-colors duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </span>
                            <input type="number" name="amount" id="amount" required
                                   class="pl-12 pr-4 py-3 mt-1 block w-full rounded-lg border border-gray-200 bg-gray-50 text-gray-900 placeholder-gray-400 shadow-sm focus:border-blue-primary focus:ring-2 focus:ring-blue-primary/30 focus:bg-white sm:text-sm transition-all duration-300 hover:border-gray-300 hover:bg-white group-hover:shadow-md"
                                   placeholder="5000000" min="1000000">
                            <span class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 text-xs font-medium">
                                IDR
                            </span>
                        </div>
                        @error('amount')
                            <p class="mt-2 text-xs text-red-600 animate-pulse">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Duration -->
                    <div>
                        <label for="duration" class="block text-sm font-semibold text-gray-700 mb-2">
                            Jangka Waktu (Bulan)
                        </label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 group-hover:text-blue-primary transition-colors duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </span>
                            <input type="number" name="duration" id="duration" required
                                   class="pl-12 pr-16 py-3 mt-1 block w-full rounded-lg border border-gray-200 bg-gray-50 text-gray-900 placeholder-gray-400 shadow-sm focus:border-blue-primary focus:ring-2 focus:ring-blue-primary/30 focus:bg-white sm:text-sm transition-all duration-300 hover:border-gray-300 hover:bg-white group-hover:shadow-md"
                                   placeholder="12" min="1" max="60">
                            <span class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 text-xs font-medium">
                                Bulan
                            </span>
                        </div>
                        @error('duration')
                            <p class="mt-2 text-xs text-red-600 animate-pulse">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Document -->
                    <div>
                        <label for="document" class="block text-sm font-semibold text-gray-700 mb-1">
                            Dokumen Pendukung
                        </label>
                        <div class="relative border-2 border-dashed border-gray-200 rounded-lg p-4 hover:border-blue-primary transition-colors duration-200">
                            <input type="file" name="document" id="document" required
                                   accept=".pdf,.jpg,.png"
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-primary file:text-white file:font-medium file:hover:bg-blue-600 file:transition-colors file:cursor-pointer">
                            <p class="mt-2 text-xs text-gray-500">Unggah slip gaji atau dokumen lainnya (PDF, JPG, PNG, maks 2MB)</p>
                        </div>
                        @error('document')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Connect MetaMask Button -->
                <div class="mt-6">
                    <button type="button" id="connectMetaMask"
                            class="inline-flex items-center px-6 py-3 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-12 0 6 6 0 0112 0z"></path>
                        </svg>
                        Connect MetaMask
                    </button>
                </div>

                <!-- Submit Button -->
                <div class="mt-8 flex justify-end">
                    <button type="button" id="submitLoan"
                            class="inline-flex items-center px-6 py-3 bg-blue-primary text-white font-semibold rounded-lg hover:bg-blue-600 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 disabled:bg-gray-400 disabled:cursor-not-allowed"
                            disabled>
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        Ajukan Pinjaman
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Include app.js -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        document.getElementById('connectMetaMask').addEventListener('click', async () => {
            try {
                await window.connectMetaMask();
                document.getElementById('connectMetaMask').classList.add('hidden');
                document.getElementById('submitLoan').disabled = false;
                alert('MetaMask terhubung!');
            } catch (error) {
                alert('Gagal menghubungkan MetaMask: ' + error.message);
            }
        });

        document.getElementById('submitLoan').addEventListener('click', async () => {
            const amount = document.getElementById('amount').value;
            const duration = document.getElementById('duration').value;

            if (!amount || !duration) {
                alert('Harap isi jumlah dan jangka waktu!');
                return;
            }

            try {
                const loanId = await window.requestCredit(amount, duration);
                document.getElementById('blockchain_loan_id').value = loanId;
                document.getElementById('loanForm').submit();
            } catch (error) {
                alert('Gagal mengajukan pinjaman: ' + error.message);
            }
        });
    </script>
@endsection
