@extends('layouts.app')

@section('title', 'Kirim Pesan Dukungan')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Kirim Pesan Dukungan</h1>

    <form action="{{ route('support.store') }}" method="POST" class="bg-white shadow rounded-lg p-6">
        @csrf

        <div class="mb-4">
            <label for="subject" class="block text-sm font-medium text-gray-700">Subjek</label>
            <input type="text" name="subject" id="subject" 
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-primary focus:ring-blue-primary sm:text-sm"
                   required>
            @error('subject')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="message" class="block text-sm font-medium text-gray-700">Pesan</label>
            <textarea name="message" id="message" rows="6"
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-primary focus:ring-blue-primary sm:text-sm"
                      required></textarea>
            @error('message')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit" class="navbar-button">
                Kirim Pesan
            </button>
        </div>
    </form>
</div>
@endsection