@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<script>
    window.Laravel = {
        csrfToken: '{{ csrf_token() }}',
        routes: {
            walletStore: '{{ route('wallet.store') }}',
            walletAddress:'{{route('wallet.address')}}'
        }
    };
</script>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Notifikasi -->
    @if (session('notification'))
        {{-- <div class="bg-[#001125] border-l-4 border-light-blue text-sky-blue p-4 mb-8 rounded-r-lg shadow-lg animate-slide-in"> --}}
            {{-- <p>{{ session('notification') }}</p> --}}
        </div>
    @endif

    <h1 class="text-4xl font-bold text-sky-blue mb-10 drop-shadow-lg tracking-wide animate-fade-in">Dashboard</h1>

<!-- Card MetaMask/Wallet -->
<div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 mb-10 card-hover transition-all duration-300 hover:shadow-lg">
    <div class="relative bg-white rounded-lg p-6 text-gray-900 overflow-hidden">
        <!-- Header Card -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="text-xl font-semibold text-gray-900 tracking-wide leading-relaxed">MetaMask Wallet</h3>
                <p class="text-sm text-gray-500 mt-2 flex items-center leading-loose">
                    <span class="mr-3 text-blue-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </span>
                    Saldo: <span id="wallet-balance" class="font-medium text-blue-500 ml-1">Rp 0</span>
                </p>
            </div>
            <img src="images/MetaMask-logo.png" alt="MetaMask Logo" class="h-9 w-auto transition-transform hover:scale-105">
        </div>

        <!-- Alamat Wallet -->
        <div class="mt-4 bg-gray-50 p-3 rounded-lg border border-gray-100">
            <p class="text-sm text-gray-600 flex items-center leading-loose">
                <span class="mr-3 text-blue-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2"></path>
                    </svg>
                </span>
                Alamat: <span id="wallet-address" class="font-mono text-blue-500 ml-1 tracking-wide truncate">Belum terkoneksi</span>
            </p>
        </div>

        <!-- Tombol dan Indikator -->
        <div class="mt-6 flex items-center space-x-4">
            <button id="connect-metamask" class="relative bg-blue-600 text-white px-5 py-2 rounded-lg font-medium text-sm tracking-wider leading-relaxed transition-all duration-300 hover:bg-blue-700 hover:ring-2 hover:ring-blue-200 hover:ring-opacity-50">
                Hubungkan Wallet
            </button>
            <span id="wallet-indicator" class="h-2.5 w-2.5 bg-red-400 rounded-full ring-2 ring-red-200" title="Wallet belum terkoneksi"></span>
        </div>
    </div>
</div>

<!-- Grafik Tren Riwayat Pembayaran -->
<div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 mb-10 card-hover transition-all duration-300 hover:shadow-md">
    <div class="relative bg-white rounded-lg p-6 overflow-hidden">
        <div class="flex items-center mb-6">
            <span class="mr-3 text-blue-500">
                <!-- Ikon Chart dari Heroicons -->
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4v17h16"></path>
                </svg>
            </span>
            <h2 class="text-2xl font-semibold text-gray-900 tracking-wide leading-relaxed">Tren Riwayat Pembayaran</h2>
        </div>
        <canvas id="paymentTrendChart" class="w-full h-80"></canvas>
    </div>
</div>

<!-- Card Horizontal -->
<div class="grid grid-cols-2 gap-6 mb-2">
<!-- Card Status Pinjaman -->
<div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 mb-10 card-hover transition-all duration-300 hover:shadow-md">
    <div class="relative bg-white rounded-lg p-6 overflow-hidden">
        <!-- Header Card -->
        <div class="flex items-center space-x-4 mb-4">
            <span class="text-blue-500">
                <!-- Ikon Money dari Heroicons -->
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </span>
            <div>
                <h3 class="text-sm font-semibold text-gray-900 tracking-wide">Pinjaman Saya</h3>
                @php
                    $loans = \App\Models\LoanApplication::where('user_id', Auth::id())
                        ->where('status', 'APPROVED')
                        ->get();
                    $totalAmount = $loans->sum('amount');
                    $totalPaid = $loans->sum(function ($loan) {
                        return $loan->payments()->sum('amount');
                    });
                    $remainingAmount = $totalAmount - $totalPaid;
                    $monthlyInstallment = $loans->sum(function ($loan) {
                        return $loan->amount / $loan->duration;
                    });
                    $nextDueDate = $loans->isNotEmpty() ? now()->addMonth()->format('d M Y') : '-';
                    $status = $loans->isNotEmpty() ? 'Aktif' : 'Tidak Aktif';
                    $statusStyle = $loans->isNotEmpty() ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700';
                @endphp
                <p class="text-2xl font-bold text-gray-900 mt-1">Rp {{ number_format($remainingAmount, 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Detail -->
        <div class="mt-2 space-y-3">
            <p class="text-gray-600 text-sm flex items-center">
                <span class="mr-2 text-blue-500">
                    <!-- Ikon Credit Card dari Heroicons -->
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                </span>
                Cicilan Berikutnya:
                <span class="text-blue-500 font-medium ml-1">Rp {{ number_format($monthlyInstallment, 0, ',', '.') }}</span>
                <span class="text-gray-500 ml-1">- {{ $nextDueDate }}</span>
            </p>
            <p class="text-gray-600 text-sm flex items-center">
                <span class="mr-2 text-blue-500">
                    <!-- Ikon Check Circle dari Heroicons -->
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </span>
                Status:
                <span class="inline-block {{ $statusStyle }} text-xs font-medium px-2.5 py-1 rounded-full ml-2">
                    {{ $status }}
                </span>
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="mt-6 flex items-center space-x-4">
            <button class="bg-blue-500 text-white px-5 py-2 rounded-lg font-medium text-sm tracking-wide transition-all duration-300 hover:bg-blue-600 hover:ring-2 hover:ring-blue-200 hover:ring-opacity-50">
                Bayar Cicilan
            </button>
            <a href="#" class="relative text-blue-500 text-sm font-medium tracking-wide transition-all duration-300 hover:text-blue-600 group">
                Lihat Detail
                <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
            </a>
        </div>
    </div>
</div>

<!-- Card Status Pengajuan -->
<div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 mb-10 card-hover transition-all duration-300 hover:shadow-md">
    <div class="relative bg-white rounded-lg p-6 overflow-hidden">
        <!-- Header Card -->
        <div class="flex items-center space-x-4 mb-4">
            <span class="text-blue-500">
                <!-- Ikon Document dari Heroicons -->
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </span>
            <div>
                <h3 class="text-sm font-semibold text-gray-900 tracking-wide">Pengajuan Pinjaman</h3>
                @php
                    $loan = \App\Models\LoanApplication::where('user_id', Auth::id())
                        ->orderBy('created_at', 'desc')
                        ->first();
                    $remainingAmount = $loan && $loan->status === 'APPROVED' ? ($loan->amount - $loan->payments()->sum('amount')) : ($loan ? $loan->amount : 0);
                    $monthlyInstallment = $loan && $loan->status === 'APPROVED' ? ($loan->amount / $loan->duration) : 0;
                    $nextDueDate = $loan && $loan->status === 'APPROVED' ? now()->addMonth()->format('d M Y') : '-';
                    $durationInMonths = $loan ? $loan->duration : 0;
                    $statusLabels = [
                        'PENDING' => 'Menunggu',
                        'APPROVED' => 'Disetujui',
                        'REJECTED' => 'Ditolak'
                    ];
                    $statusStyles = [
                        'PENDING' => 'bg-yellow-100 text-yellow-700',
                        'APPROVED' => 'bg-green-100 text-green-700',
                        'REJECTED' => 'bg-red-100 text-red-700'
                    ];
                @endphp
                <p class="text-2xl font-bold text-gray-900 mt-1">Rp {{ number_format($remainingAmount, 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Detail -->
        <div class="mt-2 space-y-3">
            @if (!$loan)
                <p class="text-gray-600 text-sm">Belum ada pengajuan pinjaman.</p>
            @else
                <p class="text-gray-600 text-sm flex items-center">
                    <span class="mr-2 text-blue-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </span>
                    Cicilan Berikutnya:
                    <span class="text-blue-500 font-medium ml-1">Rp {{ number_format($monthlyInstallment, 0, ',', '.') }}</span>
                    <span class="text-gray-500 ml-1">- {{ $nextDueDate }}</span>
                </p>
                <p class="text-gray-600 text-sm flex items-center">
                    <span class="mr-2 text-blue-500">
                        <!-- Ikon Clock dari Heroicons -->
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </span>
                    Status:
                    <span class="inline-block {{ $statusStyles[$loan->status] }} text-xs font-medium px-2.5 py-1 rounded-full ml-2">
                        {{ $statusLabels[$loan->status] }}
                    </span>
                </p>
                <p class="text-gray-600 text-sm flex items-center">
                    <span class="mr-2 text-blue-500">
                        <!-- Ikon Calendar dari Heroicons -->
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </span>
                    Jangka Waktu: <span class="text-blue-500 font-medium ml-1">{{ $durationInMonths ? $durationInMonths . ' Bulan' : '-' }}</span>
                </p>
            @endif
        </div>
    </div>
</div>
</div>

<!-- Tabel Riwayat Pembayaran -->
<div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 transition-all duration-300 card-hover hover:shadow-md">
    <div class="relative bg-white rounded-lg p-6 overflow-hidden">
        <!-- Header -->
        <h2 class="text-xl font-semibold text-gray-900 mb-6 tracking-wide leading-relaxed">Riwayat Pembayaran</h2>

        <!-- Tabel -->
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
                    @forelse ($payments as $payment)
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-all duration-200">
                            <td class="px-6 py-4 flex items-center">
                                <span class="mr-2 text-blue-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </span>
                                {{ $payment->payment_date->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 font-mono text-gray-800">
                                Rp {{ number_format($payment->amount, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-block bg-green-100 text-green-700 text-xs font-medium px-2.5 py-1 rounded-full">
                                    {{ $payment->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500">Tidak ada riwayat pembayaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Action Links -->
        <div class="mt-6 flex items-center space-x-6">
            <a href="{{ route('payments.history') }}" class="relative text-blue-500 text-sm font-medium tracking-wide transition-all duration-300 hover:text-blue-600 group">
                Lihat Semua
                <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
            </a>
            <a href="#" class="relative text-blue-500 text-sm font-medium tracking-wide transition-all duration-300 hover:text-blue-600 group">
                Cetak Laporan (PDF)
                <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
            </a>
        </div>
    </div>
</div>

<!-- Chart.js CDN dan Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('paymentTrendChart').getContext('2d');
    const paymentTrendChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan 2025', 'Feb 2025', 'Mar 2025','April 2025'],
            datasets: [{
                label: 'Jumlah Pembayaran (Rp)',
                data: [1500000, 1600000, 1700000,1600000],
                borderColor: '#2A9DF4',
                backgroundColor: 'rgba(42, 157, 244, 0.1)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#D0EFFF',
                pointBorderColor: '#2A9DF4',
                pointRadius: 6,
                pointHoverRadius: 8,
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    grid: { color: 'rgba(42, 157, 244, 0.1)' },
                    ticks: { color: '#D0EFFF', font: { size: 12 } }
                },
                y: {
                    grid: { color: 'rgba(42, 157, 244, 0.1)' },
                    ticks: { color: '#D0EFFF', beginAtZero: true, font: { size: 12 } }
                }
            },
            plugins: {
                legend: { labels: { color: '#D0EFFF', font: { size: 14 } } }
            },
            animation: {
                duration: 1500,
                easing: 'easeInOutQuart'
            }
        }
    });
</script>

<style>
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes slideIn {
        from { transform: translateX(-100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    .animate-fade-in {
        animation: fadeIn 1s ease-in-out;
    }
    .animate-slide-in {
        animation: slideIn 0.8s ease-in-out;
    }
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(42, 157, 244, 0.2);
    }
</style>
@endsection
