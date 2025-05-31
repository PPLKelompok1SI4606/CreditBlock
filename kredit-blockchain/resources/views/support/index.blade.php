@extends('layouts.app')

@section('title', 'Kontak Dukungan')

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
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-800 tracking-tight">Kontak Dukungan</h1>
            <p class="mt-3 text-lg text-gray-600 max-w-2xl mx-auto">Lihat riwayat pesan dukungan Anda dan kirim pesan baru.</p>
        </div>

        <!-- Messages Card -->
        <div class="relative bg-white bg-opacity-95 backdrop-blur-xl rounded-2xl shadow-2xl p-8 transition-all duration-500 hover:-translate-y-2 hover:shadow-3xl animate-fade-in">
            <!-- Header with Button -->
            <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4">
                <h2 class="text-xl font-semibold text-gray-800">Daftar Pesan</h2>
                <a href="{{ route('support.create') }}"
                   class="bg-blue-600 text-white px-6 py-3 rounded-lg font-medium text-sm shadow-lg overflow-hidden group transition-all duration-300 hover:scale-105 hover:shadow-[0_6px_15px_rgba(59,130,246,0.4)]">
                    <span class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></span>
                    <svg class="w-5 h-5 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Kirim Pesan Baru
                </a>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-8 p-4 bg-green-100 border-l-4 border-green-500 text-green-800 rounded-xl flex items-center animate-pulse">
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

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-blue-50 text-gray-700">
                        <tr>
                            <th class="py-3 px-4 rounded-tl-lg font-medium uppercase tracking-wider">Subjek</th>
                            <th class="py-3 px-4 font-medium uppercase tracking-wider">Status</th>
                            <th class="py-3 px-4 font-medium uppercase tracking-wider">Tanggal</th>
                            <th class="py-3 px-4 rounded-tr-lg font-medium uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($messages as $message)
                            <tr class="hover:bg-blue-50/50 transition-colors duration-200">
                                <td class="py-4 px-4 text-gray-900">{{ $message->subject }}</td>
                                <td class="py-4 px-4">
                                    <span class="px-3 py-1 text-xs font-medium rounded-full
                                        {{ $message->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                        {{ $message->status === 'pending' ? 'Menunggu' : 'Dijawab' }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-gray-900">
                                    {{ \Carbon\Carbon::parse($message->created_at)->translatedFormat('d F Y') }}
                                </td>
                                <td class="py-4 px-4 text-right">
                                    <a href="{{ route('support.show', $message) }}"
                                       class="text-blue-600 hover:text-blue-800 font-medium transition-colors duration-200 relative group">
                                        Lihat
                                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-6 px-4 text-center text-gray-500">
                                    Belum ada pesan dukungan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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
