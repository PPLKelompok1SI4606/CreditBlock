@extends('layouts.app')
@section('title', 'Riwayat Pembayaran')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-4xl font-bold text-sky-blue mb-10 drop-shadow-lg tracking-wide animate-fade-in">Riwayat Pembayaran</h1>
    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 transition-all duration-300 card-hover hover:shadow-md">
        <div class="relative bg-white rounded-lg p-6 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-gray-700 text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-gray-900">
                            <th class="px-6 py-4 text-left rounded-tl-lg font-medium tracking-wide">Tanggal</th>
                            <th class="px-6 py-4 text-left font-medium tracking-wide">Nominal</th>
                            <th class="px-6 py-4 text-left rounded-tr-lg font-medium tracking-wide">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <div class="mb-4">
                        <form method="GET" action="{{ route('payments.history') }}">
                            <select name="sort" id="sort" onchange="this.form.submit()" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Tanggal Terbaru</option>
                                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Tanggal Terlama</option>
                            </select>
                        </form>
                    </div>
                        @foreach ($payments as $payment)
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition-all duration-200">
                                <td class="px-6 py-4 flex items-center">
                                    <span class="mr-2 text-blue-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </span>
                                    {{ $payment->payment_date->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 font-mono text-gray-800">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-block bg-green-100 text-green-700 text-xs font-medium px-2.5 py-1 rounded-full">
                                        {{ $payment->status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection