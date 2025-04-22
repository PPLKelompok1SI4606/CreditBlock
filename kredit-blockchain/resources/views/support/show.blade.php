@extends('layouts.app')

@section('title', 'Detail Pesan Dukungan')

@section('content')
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Detail Pesan Dukungan</h1>
            <a href="{{ route('support.index') }}"
               class="text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors duration-200">
                Kembali ke Daftar Pesan
            </a>
        </div>

        <!-- Message Card -->
        <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-lg transition-all duration-300">
            <!-- Subject and Metadata -->
            <div class="mb-6">
                <h3 class="text-lg sm:text-xl font-semibold text-gray-900">{{ $supportMessage->subject }}</h3>
                <p class="mt-1 text-sm text-gray-500">
                    Dikirim pada {{ \Carbon\Carbon::parse($supportMessage->created_at)->translatedFormat('d F Y H:i') }}
                </p>
            </div>

            <!-- User Message -->
            <div class="mb-8">
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <p class="text-gray-700 leading-relaxed">{{ $supportMessage->message }}</p>
                </div>
            </div>

            <!-- Admin Response (if exists) -->
            @if ($supportMessage->response)
                <div class="border-t border-gray-200 pt-6">
                    <h4 class="text-md font-semibold text-gray-900">Respon Admin</h4>
                    <p class="mt-1 text-sm text-gray-500">
                        Dijawab pada {{ \Carbon\Carbon::parse($supportMessage->responded_at)->translatedFormat('d F Y H:i') }}
                    </p>
                    <div class="mt-4 bg-green-50 p-4 rounded-lg border border-green-200">
                        <p class="text-gray-700 leading-relaxed">{{ $supportMessage->response }}</p>
                    </div>
                </div>
            @endif

            <!-- Back Button -->
            <div class="mt-8 flex justify-end">
                <a href="{{ route('support.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-all duration-200 shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-gray-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali ke Daftar Pesan
                </a>
            </div>
        </div>
    </div>
@endsection
