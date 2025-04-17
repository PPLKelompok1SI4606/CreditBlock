@extends('layouts.admin')

@section('title', 'Detail Pesan Dukungan')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Detail Pesan Dukungan</h1>

    <div class="bg-white shadow rounded-lg p-6">
        <div class="mb-4">
            <h3 class="text-lg font-medium text-gray-900">{{ $supportMessage->subject }}</h3>
            <p class="mt-1 text-sm text-gray-500">
                Dari: {{ $supportMessage->user->name }}<br>
                Dikirim pada {{ $supportMessage->created_at ? $supportMessage->created_at->format('d M Y H:i') : '-' }}
            </p>
        </div>

        <div class="mb-6">
            <p class="text-gray-700">{{ $supportMessage->message }}</p>
        </div>

        @if ($supportMessage->response)
            <div class="border-t pt-4 mb-6">
                <h4 class="text-md font-medium text-gray-900">Respon Anda</h4>
                <p class="mt-1 text-sm text-gray-500">
                    Dijawab pada {{ $supportMessage->responded_at ? $supportMessage->responded_at->format('d M Y H:i') : '-' }}
                </p>
                <p class="mt-2 text-gray-700">{{ $supportMessage->response }}</p>
            </div>
        @else
            <form action="{{ route('admin.support.respond', $supportMessage) }}" method="POST" class="mb-6">
                @csrf
                <div class="mb-4">
                    <label for="response" class="block text-sm font-medium text-gray-700">Respon</label>
                    <textarea name="response" id="response" rows="6"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-primary focus:ring-blue-primary sm:text-sm"
                            required></textarea>
                    @error('response')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="navbar-button">
                        Kirim Respon
                    </button>
                </div>
            </form>
        @endif

        <div>
            <a href="{{ route('admin.support.index') }}"
               class="text-blue-primary hover:text-blue-700">
                Kembali ke Daftar Pesan
            </a>
        </div>
    </div>
</div>
@endsection
