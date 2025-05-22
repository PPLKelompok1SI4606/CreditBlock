@extends('layouts.app')

@section('title', 'Detail Pesan Dukungan')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-blue-50 to-gray-100 relative overflow-hidden">
    <!-- Subtle Particle Background -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="particle particle-1"></div>
        <div class="particle particle-2"></div>
        <div class="particle particle-3"></div>
    </div>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12 relative z-10">
        <!-- Hero Section -->
        <div class="text-center mb-12 animate-fade-in">
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-800 tracking-tight">Detail Pesan Dukungan</h1>
            <p class="mt-3 text-lg text-gray-600 max-w-2xl mx-auto">Lihat detail pesan Anda dan respon dari tim dukungan.</p>
        </div>

        <!-- Message Card -->
        <div class="relative bg-white bg-opacity-95 backdrop-blur-xl rounded-2xl shadow-2xl p-8 transition-all duration-500 hover:-translate-y-2 hover:shadow-3xl animate-fade-in">
            <!-- Subject and Metadata -->
            <div class="mb-8">
                <h3 class="text-xl sm:text-2xl font-semibold text-gray-800">{{ $supportMessage->subject }}</h3>
                <p class="mt-2 text-sm text-gray-500">
                    Dikirim pada {{ \Carbon\Carbon::parse($supportMessage->created_at)->translatedFormat('d F Y H:i') }}
                </p>
            </div>

            <!-- User Message -->
            <div class="mb-8">
                <div class="bg-blue-50/50 p-6 rounded-lg border border-blue-100">
                    <p class="text-gray-700 leading-relaxed">{{ $supportMessage->message }}</p>
                </div>
            </div>

            <!-- Admin Response (if exists) -->
            @if ($supportMessage->response)
                <div class="border-t border-gray-200 pt-8">
                    <h4 class="text-lg font-semibold text-gray-800">Respon Admin</h4>
                    <p class="mt-2 text-sm text-gray-500">
                        Dijawab pada {{ \Carbon\Carbon::parse($supportMessage->responded_at)->translatedFormat('d F Y H:i') }}
                    </p>
                    <div class="mt-4 bg-green-50 p-6 rounded-lg border border-green-100">
                        <p class="text-gray-700 leading-relaxed">{{ $supportMessage->response }}</p>
                    </div>
                </div>
            @endif

            <!-- Back Button -->
            <div class="mt-8 flex justify-end">
                <a href="{{ route('support.index') }}"
                   class="relative bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-3 rounded-lg font-medium text-sm shadow-lg overflow-hidden group transition-all duration-300 hover:scale-105 hover:shadow-[0_6px_15px_rgba(59,130,246,0.4)]">
                    <span class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></span>
                    <svg class="w-5 h-5 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali ke Daftar Pesan
                </a>
            </div>
        </div>
    </div>

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
