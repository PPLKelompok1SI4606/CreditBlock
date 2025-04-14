@extends('layouts.app')
@section('title', 'Membayar Cicilan')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-4xl font-bold text-sky-blue mb-10 drop-shadow-lg tracking-wide animate-fade-in">Membayar Cicilan</h1>
    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 mb-10 card-hover transition-all duration-300 hover:shadow-md">
        <div class="relative bg-white rounded-lg p-6 overflow-hidden">
            <h2 class="text-2xl font-semibold text-gray-900 mb-6 tracking-wide leading-relaxed">Informasi Pembayaran</h2>
            <p class="text-gray-600 text-lg mb-4">Sisa Pembayaran Cicilan: <span class="font-bold text-blue-500">Rp {{ number_format($remainingAmount, 0, ',', '.') }}</span></p>
            <form action="{{ route('payment.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="payment_date" class="block text-sm font-medium text-gray-700">Tanggal Pembayaran</label>
                    <input type="date" name="payment_date" id="payment_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>
                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg font-medium text-sm tracking-wider leading-relaxed transition-all duration-300 hover:bg-blue-700 hover:ring-2 hover:ring-blue-200 hover:ring-opacity-50">
                    Bayar Cicilan Sekarang
                </button>
            </form>
        </div>
    </div>
</div>
@endsection