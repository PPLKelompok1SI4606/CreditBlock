@extends('layouts.app')

@section('title', 'Kontak Dukungan')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Kontak Dukungan</h1>
            <a href="{{ route('support.create') }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-blue-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Kirim Pesan Baru
            </a>
        </div>

        <!-- Messages Card -->
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
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="py-3 px-4 rounded-tl-lg text-sm font-medium uppercase tracking-wider">Subjek</th>
                            <th class="py-3 px-4 text-sm font-medium uppercase tracking-wider">Status</th>
                            <th class="py-3 px-4 text-sm font-medium uppercase tracking-wider">Tanggal</th>
                            <th class="py-3 px-4 rounded-tr-lg text-sm font-medium uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($messages as $message)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
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
                                       class="text-blue-600 hover:text-blue-700 font-medium transition-colors duration-200">
                                        Lihat
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
@endsection
