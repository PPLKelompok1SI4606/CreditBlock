@extends('layouts.app')

@section('title', 'Detail Pesan Dukungan')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Detail Pesan Dukungan</h1>

    <div class="bg-white shadow rounded-lg p-6">
        <div class="mb-4">
            <h3 class="text-lg font-medium text-gray-900">{{ $supportMessage->subject }}</h3>
            <p class="mt-1 text-sm text-gray-500">
                Dikirim pada {{ $supportMessage->created_at->format('d M Y H:i') }}
            </p>
        </div>

        <div class="mb-6">
            <p class="text-gray-700">{{ $supportMessage->message }}</p>
        </div>

        @if ($supportMessage->response)
            <div class="border-t pt-4">
                <h4 class="text-md font-medium text-gray-900">Respon Admin</h4>
                <p class="mt-1 text-sm text-gray-500">
                    Dijawab pada {{ $supportMessage->responded_at->format('d M Y H:i') }}
                </p>
                <p class="mt-2 text-gray-700">{{ $supportMessage->response }}</p>
            </div>
        @endif

        <div class="mt-6">
            <a href="{{ route('support.index') }}" 
               class="text-blue-primary hover:text-blue-700">
                Kembali ke Daftar Pesan
            </a>
        </div>
    </div>
</div>
@endsection