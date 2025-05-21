@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<script>
    window.Laravel = {
        csrfToken: '{{ csrf_token() }}',
        routes: {
            walletStore: '{{ route('wallet.store') }}',
            walletAddress: '{{ route('wallet.address') }}'
        }
    };
</script>

<!-- Add Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>

<div class="min-h-screen bg-gradient-to-b from-blue-50 to-gray-100 relative overflow-hidden">
    <!-- Subtle Particle Background -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="particle particle-1"></div>
        <div class="particle particle-2"></div>
        <div class="particle particle-3"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 relative z-10">
        <!-- Hero Section -->
        <div class="text-center mb-12 animate-fade-in">
            <h1 class="text-4xl sm:text-5xl font-bold text-gray-800 tracking-tight">Selamat Datang</h1>
            <p class="mt-3 text-lg text-gray-600 max-w-2xl mx-auto">Kelola keuangan Anda dengan mudah, dari dompet digital hingga pinjaman, dalam satu tempat.</p>
        </div>

        <!-- Notifikasi -->
        @if (session('notification'))
            <div class="bg-blue-600 text-white p-4 rounded-xl shadow-lg mb-10 flex items-center animate-slide-in max-w-3xl mx-auto">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-sm font-medium">{{ session('notification') }}</p>
            </div>
        @endif

        <!-- Wallet Card -->
        <div class="relative bg-white bg-opacity-95 backdrop-blur-xl rounded-2xl shadow-2xl p-8 mb-10 transform transition-all duration-500 hover:-translate-y-2 hover:shadow-3xl z-20">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">MetaMask Wallet</h2>
                <img src="{{ asset('images/MetaMask-Logo.png') }}" alt="MetaMask Logo" class="h-10 w-auto transition-transform duration-300 hover:scale-110">
            </div>
            <p class="text-base text-gray-600 mb-6 flex items-center">
                <svg class="w-5 h-5 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
                Saldo: <span id="wallet-balance" class="font-semibold text-blue-600 ml-2">Rp 0</span>
            </p>
            <div class="bg-gray-50 rounded-lg p-4 mb-6 group relative cursor-pointer" id="wallet-address-container">
                <p class="text-sm text-gray-600 flex items-center">
                    <svg class="w-5 h-5 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2"></path>
                    </svg>
                    Alamat: <span id="wallet-address" class="font-mono text-blue-600 ml-2 truncate max-w-[200px] sm:max-w-[350px]">{{ Auth::user()->wallet_address ?? 'Belum terkoneksi' }}</span>
                </p>
                <span class="absolute hidden group-hover:block -top-8 left-1/2 transform -translate-x-1/2 bg-blue-600 text-white text-xs rounded py-1 px-2 animate-slide-up">Copy Address</span>
            </div>
            <div class="flex items-center space-x-4">
                <button id="connect-metamask" class="relative bg-blue-500 text-white px-6 py-2.5 rounded-lg text-sm font-medium shadow-lg overflow-hidden group">
                    <span class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></span>
                    Hubungkan Wallet
                </button>
                <span id="wallet-indicator" class="h-2.5 w-2.5 bg-red-500 rounded-full ring-2 ring-red-200 animate-pulse" title="Wallet belum terkoneksi"></span>
            </div>
        </div>

        <!-- Loan Status Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 mb-10 -mt-4 relative z-10">
            <!-- Pinjaman Saya -->
            <div class="relative bg-white bg-opacity-95 backdrop-blur-xl rounded-2xl shadow-2xl p-8 transform transition-all duration-500 hover:-translate-y-2 hover:shadow-3xl">
                <div class="flex items-center space-x-4 mb-6">
                    <svg class="w-7 h-7 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-800">Pinjaman Saya</h3>
                </div>
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
                    $statusStyle = $loans->isNotEmpty() ? 'bg-blue-100 text-blue-700 animate-pulse' : 'bg-gray-100 text-gray-700';
                @endphp
                <p class="text-3xl font-bold text-gray-800 mb-6">Rp {{ number_format($remainingAmount, 0, ',', '.') }}</p>
                @if ($loans->isEmpty())
                    <p class="text-gray-600 text-sm">Belum ada pinjaman aktif.</p>
                @else
                    <p class="text-gray-600 text-sm mb-3 flex items-center">
                        <svg class="w-5 h-5 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        Cicilan: <span class="font-medium text-blue-600 ml-2">Rp {{ number_format($monthlyInstallment, 0, ',', '.') }} - {{ $nextDueDate }}</span>
                    </p>
                    <p class="text-gray-600 text-sm flex items-center">
                        <svg class="w-5 h-5 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Status: <span class="inline-block {{ $statusStyle }} text-xs font-medium px-2.5 py-1 rounded-full ml-2">{{ $status }}</span>
                    </p>
                @endif
                <div class="mt-6 flex space-x-4">
                    <a href="{{ route('payments.create') }}" class="relative bg-blue-500 text-white px-6 py-2.5 rounded-lg text-sm font-medium shadow-lg overflow-hidden group">
                        <span class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></span>
                        Bayar Cicilan
                    </a>
                    <a href="{{ route('loan-applications.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium relative group">
                        Lihat Detail
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                    </a>
                </div>
            </div>

            <!-- Pengajuan Pinjaman -->
            <div class="relative bg-white bg-opacity-95 backdrop-blur-xl rounded-2xl shadow-2xl p-8 transform transition-all duration-500 hover:-translate-y-2 hover:shadow-3xl">
                <div class="flex items-center space-x-4 mb-6">
                    <svg class="w-7 h-7 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-800">Pengajuan Pinjaman</h3>
                </div>
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
                        'REJECTED' => 'Ditolak',
                        'Belum Lunas' => 'Belum Lunas',
                        'Lunas' => 'Lunas'
                    ];
                    $statusStyles = [
                        'PENDING' => 'bg-yellow-100 text-yellow-800 animate-pulse',
                        'APPROVED' => 'bg-blue-100 text-blue-800 animate-pulse',
                        'REJECTED' => 'bg-red-100 text-red-800',
                        'Belum Lunas' => 'bg-orange-100 text-orange-800 animate-pulse',
                        'Lunas' => 'bg-blue-100 text-blue-800'
                    ];
                @endphp
                <p class="text-3xl font-bold text-gray-800 mb-6">Rp {{ number_format($remainingAmount, 0, ',', '.') }}</p>
                @if (!$loan)
                    <p class="text-gray-600 text-sm">Belum ada pengajuan pinjaman.</p>
                @else
                    <p class="text-gray-600 text-sm mb-3 flex items-center">
                        <svg class="w-5 h-5 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        Cicilan: <span class="font-medium text-blue-600 ml-2">Rp {{ number_format($monthlyInstallment, 0, ',', '.') }} - {{ $nextDueDate }}</span>
                    </p>
                    <p class="text-gray-600 text-sm mb-3 flex items-center">
                        <svg class="w-5 h-5 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Status: <span class="inline-block {{ $statusStyles[$loan->status] }} text-xs font-medium px-2.5 py-1 rounded-full ml-2">{{ $statusLabels[$loan->status] }}</span>
                    </p>
                    <p class="text-gray-600 text-sm flex items-center">
                        <svg class="w-5 h-5 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Jangka Waktu: <span class="font-medium text-blue-600 ml-2">{{ $durationInMonths ? $durationInMonths . ' Bulan' : '-' }}</span>
                    </p>
                @endif
                <div class="mt-6 flex space-x-4">
                    <a href="{{ route('loan-applications.index') }}" class="relative bg-blue-500 text-white px-6 py-2.5 rounded-lg text-sm font-medium shadow-lg overflow-hidden group">
                        <span class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></span>
                        Riwayat Peminjaman
                    </a>
                    <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium relative group {{ !$loan ? 'pointer-events-none opacity-50' : '' }}">
                        Lihat Detail
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Loan History Chart -->
        <div class="relative bg-white bg-opacity-95 backdrop-blur-xl rounded-2xl shadow-2xl p-8 mb-10 transform transition-all duration-500 hover:-translate-y-2 hover:shadow-3xl -mt-4 z-10">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Grafik Riwayat Peminjaman</h2>
            @if (empty($chartData))
                <div class="text-gray-600 text-center py-8 text-base">Tidak ada riwayat peminjaman yang disetujui untuk ditampilkan.</div>
            @else
                <div class="h- w-full">
                    <canvas id="loanHistoryChart"></canvas>
                </div>
            @endif
        </div>

        <!-- Payment History Table -->
        <div class="relative bg-white bg-opacity-95 backdrop-blur-xl rounded-2xl shadow-2xl p-8 transform transition-all duration-500 hover:-translate-y-2 hover:shadow-3xl">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Riwayat Pembayaran</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-base text-gray-600">
                    <thead>
                        <tr class="bg-blue-50 text-gray-700">
                            <th class="px-6 py-4 text-left font-medium">Tanggal</th>
                            <th class="px-6 py-4 text-left font-medium">Nominal</th>
                            <th class="px-6 py-4 text-left font-medium">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($payments as $payment)
                            <tr class="border-b border-gray-100 hover:bg-blue-50/30 transition-all duration-200">
                                <td class="px-6 py-4 flex items-center">
                                    <svg class="w-5 h-5 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ $payment->payment_date->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 font-mono">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-block text-xs font-medium px-3 py-1 rounded-full {{ $payment->status === 'LUNAS' ? 'bg-blue-100 text-blue-700 animate-pulse' : 'bg-yellow-100 text-yellow-700 animate-pulse' }}">{{ $payment->status }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-gray-600">Tidak ada riwayat pembayaran.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-6 flex space-x-4">
                <a href="{{ route('payments.history') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium relative group">
                    Lihat Semua
                    <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                </a>
                <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium relative group">
                    Cetak Laporan (PDF)
                    <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                </a>
            </div>
        </div>
    </div>

    <!-- Chart.js and Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loanData = @json($chartData ?? []);
            console.log('Loan Data:', loanData);

            if (loanData && loanData.length > 0) {
                const ctx = document.getElementById('loanHistoryChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: loanData.map(item => item.label),
                        datasets: [{
                            label: 'Jumlah Pinjaman',
                            data: loanData.map(item => item.amount),
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            borderColor: '#3B82F6',
                            borderWidth: 2,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: '#3B82F6',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)'
                                },
                                ticks: {
                                    callback: function(value) {
                                        return 'Rp ' + value.toLocaleString('id-ID');
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        },
                        plugins: {
                            tooltip: {
                                backgroundColor: 'rgba(59, 130, 246, 0.9)',
                                titleColor: '#fff',
                                bodyColor: '#fff',
                                borderColor: '#3B82F6',
                                borderWidth: 1,
                                padding: 10,
                                callbacks: {
                                    label: function(context) {
                                        return 'Rp ' + context.raw.toLocaleString('id-ID');
                                    }
                                }
                            },
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            } else {
                console.log('No loan data available for chart.');
            }
        });
    </script>

    <style>
        [x-cloak] { display: none; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fadeIn 0.8s ease-out; }
        .animate-slide-in { animation: slideIn 0.8s ease-out; }
        .animate-slide-up { animation: slideUp 0.5s ease-out; }
        body { font-family: 'Inter', sans-serif; }

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
@endsection
