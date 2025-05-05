@extends('layouts.admin')

@section('content')
<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-8 max-w-lg w-full">
        <button onclick="window.location.href='{{ route('admin.dashboard') }}'" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 transition-all duration-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <div class="text-center mb-6">
            <h3 class="text-2xl font-semibold text-gray-900">Verifikasi KYC</h3>
            <p class="text-sm text-gray-500 mt-1">User: {{ $user->name }}</p>
        </div>
        <div class="space-y-4 text-sm text-gray-700">
            <div class="flex items-center space-x-3">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <div>
                    <span class="text-sm font-medium text-gray-700">Nama</span>
                    <p class="text-gray-900">{{ $user->name }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                <div>
                    <span class="text-sm font-medium text-gray-700">Email</span>
                    <p class="text-gray-900">{{ $user->email }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <div>
                    <span class="text-sm font-medium text-gray-700">ID Type</span>
                    <p class="text-gray-900">{{ $user->id_type === 'ktp' ? 'KTP' : 'SIM' }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <div>
                    <span class="text-sm font-medium text-gray-700">Document</span>
                    @if($user->id_document && Storage::disk('public')->exists($user->id_document))
                        <a href="{{ Storage::url($user->id_document) }}" target="_blank" class="text-blue-500 hover:underline">View Document</a>
                    @else
                        <span class="text-gray-500">N/A</span>
                    @endif
                </div>
            </div>
        </div>
        @if($user->status_kyc === 'pending')
            <div class="mt-6 space-y-4">
                <form action="{{ route('admin.kyc.approve', $user->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Setujui</button>
                </form>
                <form action="{{ route('admin.kyc.reject', $user->id) }}" method="POST" class="inline ml-4">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Tolak</button>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection