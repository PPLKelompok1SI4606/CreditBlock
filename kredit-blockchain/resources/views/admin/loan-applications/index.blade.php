@extends('layouts.app')

@section('title', 'Kelola Pengajuan Pinjaman')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Kelola Pengajuan Pinjaman</h1>
        <a href="{{ route('admin.dashboard') }}"
           class="text-sm font-medium text-blue-primary hover:text-blue-600 transition-colors">
            Kembali ke Dashboard
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-400 text-green-700 rounded-lg flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white p-6 rounded-xl shadow-lg">
        @if ($applications->isEmpty())
            <p class="text-gray-500">Belum ada pengajuan pinjaman.</p>
        @else
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b">
                        <th class="py-2">Peminjam</th>
                        <th class="py-2">Jumlah</th>
                        <th class="py-2">Jangka Waktu</th>
                        <th class="py-2">Status</th>
                        <th class="py-2">Dokumen</th>
                        <th class="py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($applications as $application)
                        <tr class="border-b">
                            <td class="py-2">{{ $application->user->name }}</td>
                            <td class="py-2">Rp {{ number_format($application->amount, 0, ',', '.') }}</td>
                            <td class="py-2">{{ $application->duration }} Bulan</td>
                            <td class="py-2">
                                <span class="px-2 py-1 rounded {{ $application->status == 'APPROVED' ? 'bg-green-100 text-green-800' : ($application->status == 'REJECTED' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ $application->status }}
                                </span>
                            </td>
                            <td class="py-2">
                                <a href="{{ Storage::url($application->document_path) }}" target="_blank" class="text-blue-primary hover:underline">Lihat</a>
                            </td>
                            <td class="py-2">
                                @if ($application->status == 'PENDING')
                                    <form action="{{ route('admin.loan-applications.update-status', $application) }}" method="POST" class="inline-flex space-x-2">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="APPROVED">
                                        <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">Setujui</button>
                                    </form>
                                    <form action="{{ route('admin.loan-applications.update-status', $application) }}" method="POST" class="inline-flex space-x-2">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="REJECTED">
                                        <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">Tolak</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
