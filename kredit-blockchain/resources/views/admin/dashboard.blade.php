@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')

    <!-- Card Ringkasan -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10">
        <!-- Pengguna Aktif -->
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 card-hover transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
            <div class="flex items-center space-x-4">
                <span class="text-blue-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </span>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1 tracking-tight">Pengguna Aktif</h3>
                    <p class="text-3xl font-bold text-green-600">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>
        <!-- Pinjaman Aktif -->
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 card-hover transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
            <div class="flex items-center space-x-4">
                <span class="text-blue-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </span>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1 tracking-tight">Pinjaman Aktif</h3>
                    <p class="text-3xl font-bold text-green-600">{{ $activeLoans }}</p>
                </div>
            </div>
        </div>
        <!-- Pengajuan Menunggu -->
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 card-hover transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
            <div class="flex items-center space-x-4">
                <span class="text-blue-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </span>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1 tracking-tight">Pengajuan Menunggu</h3>
                    <p class="text-3xl font-bold text-green-600">{{ $pendingLoans }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Daftar Pengguna -->
    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 mb-10 transition-all duration-300 card-hover hover:shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-900 tracking-tight">Daftar Pengguna</h2>
            <div class="relative w-64">
                <form method="GET" action="{{ route('admin.dashboard') }}">
                    <input type="text" name="search" placeholder="Cari nama atau email..." value="{{ $search ?? '' }}"
                        class="w-full border border-gray-200 rounded-lg pl-10 pr-4 py-2 text-sm font-medium text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 bg-gray-50">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                </form>
            </div>
        </div>
        <div class="overflow-x-auto rounded-lg">
            <table class="w-full text-sm text-gray-900 font-medium">
                <thead>
                    <tr class="bg-gray-50 text-gray-700 uppercase text-xs tracking-wider">
                        <th class="px-6 py-4 text-left rounded-tl-lg w-16">ID</th>
                        <th class="px-6 py-4 text-left w-56">Nama</th>
                        <th class="px-6 py-4 text-left w-72">Email</th>
                        <th class="px-6 py-4 text-left w-32">Status KYC</th>
                        <th class="px-6 py-4 text-left w-48">Tanggal Daftar</th>
                        <th class="px-6 py-4 text-left rounded-tr-lg w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($users as $user)
                        <tr class="hover:bg-gray-50 transition-all duration-200">
                            <td class="px-6 py-4 w-16">{{ $user->id }}</td>
                            <td class="px-6 py-4 w-56">
                                <div class="flex items-center space-x-3">
                                    <span class="text-blue-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </span>
                                    <span>{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 w-72">
                                <div class="flex items-center space-x-3">
                                    <span class="text-blue-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </span>
                                    <span>{{ $user->email }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 w-32">
                                <span class="inline-block bg-green-100 text-green-700 text-xs font-medium px-3 py-1 rounded-full">Terverifikasi</span>
                            </td>
                            <td class="px-6 py-4 w-48">
                                <div class="flex items-center space-x-3">
                                    <span class="text-blue-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </span>
                                    <span>{{ $user->created_at->format('d M Y') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 w-32">
                                <button onclick="openModal('user-modal-{{ $user->id }}')"
                                        class="bg-blue-500 text-white px-4 py-1.5 rounded-lg text-sm font-medium tracking-wide transition-all duration-300 hover:bg-blue-600 hover:ring-2 hover:ring-blue-200 hover:ring-opacity-50">
                                    Lihat Detail
                                </button>
                            </td>
                        </tr>

                        <!-- Modal untuk Detail Pengguna -->
                        <div id="user-modal-{{ $user->id }}" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden transition-opacity duration-300">
                            <div class="bg-white rounded-2xl p-8 max-w-lg w-full transform transition-all duration-300 scale-95 opacity-0 modal-content">
                                <button onclick="closeModal('user-modal-{{ $user->id }}')"
                                        class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 transition-all duration-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                                <h3 class="text-2xl font-semibold text-gray-900 mb-6">Detail Pengguna</h3>
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
                                            <span class="text-sm font-medium text-gray-700">Status KYC</span>
                                            <p class="text-gray-900">Terverifikasi</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <div>
                                            <span class="text-sm font-medium text-gray-700">Tanggal Daftar</span>
                                            <p class="text-gray-900">{{ $user->created_at->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-6 space-y-4">
                                    <!-- Form untuk Ganti Password -->
                                    <form action="{{ route('admin.change-password', $user->id) }}" method="POST" class="space-y-3">
                                        @csrf
                                        @method('PATCH')
                                        <label for="new_password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                                        <input type="password" name="new_password" id="new_password" required
                                            class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300">
                                        <button type="submit"
                                                class="w-full bg-green-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-600 transition-all duration-300">
                                            Ganti Password
                                        </button>
                                    </form>
                                    <!-- Form untuk Hapus Pengguna -->
                                    <form action="{{ route('admin.delete-user', $user->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="w-full bg-red-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-600 transition-all duration-300"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                            Hapus Pengguna
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-6 text-center text-gray-500 text-sm">Tidak ada pengguna.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6 flex justify-center">
            {{ $users->links('vendor.pagination.tailwind') }}
        </div>
    </div>

    <!-- Tabel Pinjaman Aktif -->
    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 mb-10 transition-all duration-300 card-hover hover:shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-900 tracking-tight">Pinjaman Aktif</h2>
            <div class="relative w-64">
                <form method="GET" action="{{ route('admin.dashboard') }}">
                    <input type="text" name="search" placeholder="Cari nama atau ID..." value="{{ $search ?? '' }}"
                        class="w-full border border-gray-200 rounded-lg pl-10 pr-4 py-2 text-sm font-medium text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 bg-gray-50">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                </form>
            </div>
        </div>
        <div class="overflow-x-auto rounded-lg">
            <table class="w-full text-sm text-gray-900 font-medium">
                <thead>
                    <tr class="bg-gray-50 text-gray-700 uppercase text-xs tracking-wider">
                        <th class="px-6 py-4 text-left rounded-tl-lg w-24">ID Pinjaman</th>
                        <th class="px-6 py-4 text-left w-56">Nama Peminjam</th>
                        <th class="px-6 py-4 text-left w-40">Jumlah</th>
                        <th class="px-6 py-4 text-left w-32">Jangka Waktu</th>
                        <th class="px-6 py-4 text-left w-32">Status</th>
                        <th class="px-6 py-4 text-left rounded-tr-lg w-64">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($loanApplications as $loan)
                        <tr class="hover:bg-gray-50 transition-all duration-200">
                            <td class="px-6 py-4 w-24">P{{ str_pad($loan->id, 3, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-4 w-56">
                                <div class="flex items-center space-x-3">
                                    <span class="text-blue-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </span>
                                    <span>{{ $loan->user->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 w-40">
                                <div class="flex items-center space-x-3">
                                    <span class="text-blue-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </span>
                                    <span>Rp {{ number_format($loan->amount, 0, ',', '.') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 w-32">
                                <div class="flex items-center space-x-3">
                                    <span class="text-blue-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </span>
                                    <span>{{ $loan->duration }} Bulan</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 w-32">
                                @php
                                    $statusLabels = [
                                        'PENDING' => 'Menunggu',
                                        'APPROVED' => 'Aktif',
                                        'REJECTED' => 'Ditolak'
                                    ];
                                    $statusStyles = [
                                        'PENDING' => 'bg-yellow-100 text-yellow-700',
                                        'APPROVED' => 'bg-green-100 text-green-700',
                                        'REJECTED' => 'bg-red-100 text-red-700'
                                    ];
                                    $status = $statusLabels[strtoupper($loan->status)] ?? 'Tidak Diketahui';
                                    $style = $statusStyles[strtoupper($loan->status)] ?? 'bg-gray-100 text-gray-700';
                                @endphp
                                <span class="inline-block {{ $style }} text-xs font-medium px-3 py-1 rounded-full">{{ $status }}</span>
                            </td>
                            <td class="px-6 py-4 w-64 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <button onclick="openModal('modal-{{ $loan->id }}')"
                                            class="bg-blue-500 text-white px-3 py-1.5 rounded-lg text-xs font-medium tracking-wide transition-all duration-300 hover:bg-blue-600 hover:ring-2 hover:ring-blue-200 hover:ring-opacity-50">
                                        Lihat Detail
                                    </button>
                                    @if(strtoupper($loan->status) == 'PENDING')
                                        <form action="{{ route('admin.loan-applications.update-status', $loan->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="APPROVED">
                                            <button type="submit" class="bg-blue-900 text-white px-3 py-1.5 rounded-lg text-xs font-medium tracking-wide transition-all duration-300 hover:bg-blue-800">
                                                Setujui
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.loan-applications.update-status', $loan->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="REJECTED">
                                            <button type="submit" class="bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs font-medium tracking-wide transition-all duration-300 hover:bg-red-700">
                                                Tolak
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-6 text-center text-gray-500 text-sm">Tidak ada pengajuan pinjaman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6 flex justify-center">
            {{ $loanApplications->links('vendor.pagination.tailwind') }}
        </div>
    </div>

    <!-- Card KYC Menunggu -->
    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 transition-all duration-300 card-hover hover:shadow-lg">
        <h2 class="text-xl font-semibold text-gray-900 mb-6 tracking-tight">Verifikasi KYC</h2>
        <ul class="space-y-4">
            @forelse ($kycVerifications ?? [] as $kyc)
                <li class="flex items-center justify-between p-4 bg-gray-50 rounded-lg transition-all duration-200 hover:bg-gray-100">
                    <div class="flex items-center space-x-4">
                        <span class="text-blue-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </span>
                        <div>
                            <span class="text-gray-900 font-medium text-base">{{ $kyc->user->name }}</span>
                            <p class="text-gray-500 text-sm">Uploaded: {{ $kyc->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="bg-yellow-100 text-yellow-700 text-xs font-medium px-3 py-1 rounded-full">Menunggu</span>
                        <button onclick="openModal('kyc-modal-{{ $kyc->id }}')"
                                class="bg-blue-500 text-white px-4 py-1.5 rounded-lg text-sm font-medium tracking-wide transition-all duration-300 hover:bg-blue-600 hover:ring-2 hover:ring-blue-200 hover:ring-opacity-50">
                            Verifikasi Sekarang
                        </button>
                    </div>
                </li>
            @empty
                <li class="p-4 text-center text-gray-500 text-sm">Tidak ada verifikasi KYC menunggu.</li>
            @endforelse
        </ul>
    </div>

    <!-- Modal untuk Pengajuan Pinjaman -->
    @foreach ($loanApplications as $application)
        <div id="modal-{{ $application->id }}" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden transition-opacity duration-300">
            <div class="bg-white rounded-2xl p-8 max-w-lg w-full transform transition-all duration-300 scale-95 opacity-0 modal-content">
                <button onclick="closeModal('modal-{{ $application->id }}')"
                        class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 transition-all duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                <div class="text-center mb-6">
                    <h3 class="text-2xl font-semibold text-gray-900">Detail Pengajuan Pinjaman</h3>
                    <p class="text-sm text-gray-500 mt-1">ID: P{{ str_pad($application->id, 3, '0', STR_PAD_LEFT) }}</p>
                </div>
                <div class="space-y-4 text-sm text-gray-700">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <div>
                            <span class="text-sm font-medium text-gray-700">Nama</span>
                            <p class="text-gray-900">{{ $application->user->name }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <div>
                            <span class="text-sm font-medium text-gray-700">Email</span>
                            <p class="text-gray-900">{{ $application->user->email }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <span class="text-sm font-medium text-gray-700">Jumlah Pinjaman</span>
                            <p class="text-gray-900">Rp {{ number_format($application->amount, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <span class="text-sm font-medium text-gray-700">Jangka Waktu</span>
                            <p class="text-gray-900">{{ $application->duration }} Bulan</p>
                        </div>
                    </div>
                </div>
                <div class="mt-6 text-center">
                    <a href="{{ Storage::url($application->document_path) }}" target="_blank"
                        class="inline-flex items-center text-white bg-blue-500 px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-600 transition-all duration-300">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Lihat Dokumen Pendukung
                    </a>
                </div>
            </div>
        </div>
    @endforeach

    <!-- JavaScript untuk Mengontrol Modal -->
    <script>
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.querySelector('.modal-content').classList.remove('scale-95', 'opacity-0');
                modal.querySelector('.modal-content').classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            const modalContent = modal.querySelector('.modal-content');
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        window.onclick = function(event) {
            if (event.target.classList.contains('fixed')) {
                closeModal(event.target.id);
            }
        }
    </script>
@endsection
