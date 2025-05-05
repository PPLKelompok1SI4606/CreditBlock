@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <!-- Success Notification -->
    @if (session('status'))
        <div class="mb-8 p-4 bg-teal-100 text-teal-800 rounded-xl shadow-md">
            {{ session('status') }}
        </div>
    @endif

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <!-- Active Users -->
        <div class="bg-gradient-to-br from-white to-gray-50 border border-gray-200 rounded-xl shadow-md p-6 transform transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-indigo-100 rounded-full">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-1">Pengguna Aktif</h3>
                    <p class="text-3xl font-bold text-teal-600">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>
        <!-- Active Loans -->
        <div class="bg-gradient-to-br from-white to-gray-50 border border-gray-200 rounded-xl shadow-md p-6 transform transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-indigo-100 rounded-full">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-1">Pinjaman Aktif</h3>
                    <p class="text-3xl font-bold text-teal-600">{{ $activeLoans }}</p>
                </div>
            </div>
        </div>
        <!-- Pending Applications -->
        <div class="bg-gradient-to-br from-white to-gray-50 border border-gray-200 rounded-xl shadow-md p-6 transform transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-indigo-100 rounded-full">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-1">Pengajuan Menunggu</h3>
                    <p class="text-3xl font-bold text-teal-600">{{ $pendingLoans }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- KYC Verification Section -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-12">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Verifikasi KYC</h2>
        <ul class="space-y-4">
            @forelse ($pendingKycUsers ?? [] as $user)
                <li class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-all duration-200">
                    <div class="flex items-center space-x-4">
                        <div class="p-2 bg-indigo-100 rounded-full">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <span class="text-gray-800 font-medium text-base">{{ $user->name }}</span>
                            <p class="text-gray-500 text-sm">Uploaded: {{ $user->updated_at->format('d M Y') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-3 py-1 rounded-full">Menunggu</span>
                        <button onclick="openModal('kyc-modal-{{ $user->id }}')"
                                class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition-all duration-200">
                            Verifikasi Sekarang
                        </button>
                    </div>
                </li>
                <!-- KYC Modal -->
                <div id="kyc-modal-{{ $user->id }}" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                    <div class="bg-white rounded-xl p-8 max-w-lg w-full modal-content transition-all duration-300 opacity-0 scale-95 shadow-xl">
                        <button onclick="closeModal('kyc-modal-{{ $user->id }}')"
                                class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 transition-colors duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                        <h3 class="text-2xl font-semibold text-gray-800 mb-6">Verifikasi KYC - {{ $user->name }}</h3>
                        <div class="space-y-4 text-sm text-gray-600">
                            <div><span class="font-medium">Nama:</span> {{ $user->name }}</div>
                            <div><span class="font-medium">Email:</span> {{ $user->email }}</div>
                            <div><span class="font-medium">Tipe ID:</span> {{ $user->id_type }}</div>
                            <div>
                                <span class="font-medium">Dokumen KYC:</span>
                                <div class="mt-2 border border-gray-200 rounded-lg p-4">
                                    <img src="{{ Storage::url($user->id_document) }}" alt="Dokumen KYC" class="max-w-full h-auto rounded-lg">
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 flex space-x-4">
                            <form action="{{ route('admin.kyc.approve', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-teal-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-teal-700 transition-all duration-200">
                                    Setujui KYC
                                </button>
                            </form>
                            <form action="{{ route('admin.kyc.reject', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-700 transition-all duration-200"
                                        onclick="return confirm('Apakah Anda yakin ingin menolak KYC ini? Dokumen akan dihapus.')">
                                    Tolak KYC
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <li class="p-4 text-center text-gray-500 text-sm">Tidak ada verifikasi KYC menunggu.</li>
            @endforelse
        </ul>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-12">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Daftar Pengguna</h2>
            <div class="relative w-64">
                <form method="GET" action="{{ route('admin.dashboard') }}">
                    <input type="text" name="search" placeholder="Cari nama atau email..." value="{{ $search ?? '' }}"
                           class="w-full border border-gray-200 rounded-lg pl-10 pr-4 py-2 text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 bg-gray-50">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                </form>
            </div>
        </div>
        <div class="overflow-x-auto rounded-lg">
            <table class="w-full text-sm text-gray-600">
                <thead>
                    <tr class="bg-gray-50 text-gray-700 uppercase text-xs tracking-wider">
                        <th class="px-6 py-4 text-left rounded-tl-lg">ID</th>
                        <th class="px-6 py-4 text-left">Nama</th>
                        <th class="px-6 py-4 text-left">Email</th>
                        <th class="px-6 py-4 text-left">Status KYC</th>
                        <th class="px-6 py-4 text-left">Tanggal Daftar</th>
                        <th class="px-6 py-4 text-left rounded-tr-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($users as $user)
                        <tr class="hover:bg-gray-50 transition-all duration-200">
                            <td class="px-6 py-4">{{ $user->id }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="p-2 bg-indigo-100 rounded-full">
                                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <span>{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="p-2 bg-indigo-100 rounded-full">
                                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <span>{{ $user->email }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if ($user->is_verified)
                                    <span class="inline-block bg-teal-100 text-teal-800 text-xs font-medium px-3 py-1 rounded-full">Terverifikasi</span>
                                @elseif ($user->id_document)
                                    <span class="inline-block bg-yellow-100 text-yellow-800 text-xs font-medium px-3 py-1 rounded-full">Menunggu</span>
                                @else
                                    <span class="inline-block bg-red-100 text-red-800 text-xs font-medium px-3 py-1 rounded-full">Belum Upload</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="p-2 bg-indigo-100 rounded-full">
                                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <span>{{ $user->created_at->format('d M Y') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <button onclick="openModal('user-modal-{{ $user->id }}')"
                                        class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition-all duration-200">
                                    Lihat Detail
                                </button>
                            </td>
                        </tr>
                        <!-- User Details Modal -->
                        <div id="user-modal-{{ $user->id }}" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                            <div class="bg-white rounded-xl p-8 max-w-lg w-full modal-content transition-all duration-300 opacity-0 scale-95 shadow-xl">
                                <button onclick="closeModal('user-modal-{{ $user->id }}')"
                                        class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 transition-colors duration-200">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                                <h3 class="text-2xl font-semibold text-gray-800 mb-6">Detail Pengguna</h3>
                                <div class="space-y-4 text-sm text-gray-600">
                                    <div class="flex items-center space-x-3">
                                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <div>
                                            <span class="text-sm font-medium text-gray-700">Nama</span>
                                            <p class="text-gray-800">{{ $user->name }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        <div>
                                            <span class="text-sm font-medium text-gray-700">Email</span>
                                            <p class="text-gray-800">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <div>
                                            <span class="text-sm font-medium text-gray-700">Status KYC</span>
                                            <p class="text-gray-800">
                                                @if ($user->is_verified)
                                                    Terverifikasi
                                                @elseif ($user->id_document)
                                                    Menunggu Verifikasi
                                                @else
                                                    Belum Upload
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <div>
                                            <span class="text-sm font-medium text-gray-700">Tanggal Daftar</span>
                                            <p class="text-gray-800">{{ $user->created_at->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-6 space-y-4">
                                    <form action="{{ route('admin.change-password', $user->id) }}" method="POST" class="space-y-3">
                                        @csrf
                                        @method('PATCH')
                                        <label for="new_password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                                        <input type="password" name="new_password" id="new_password" required
                                               class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-300">
                                        <button type="submit"
                                                class="w-full bg-teal-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-teal-700 transition-all duration-200">
                                            Ganti Password
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.delete-user', $user->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="w-full bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-700 transition-all duration-200"
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

    <!-- Active Loans Table -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-12">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Pinjaman Aktif</h2>
            <div class="relative w-64">
                <form method="GET" action="{{ route('admin.dashboard') }}">
                    <input type="text" name="search" placeholder="Cari nama atau ID..." value="{{ $search ?? '' }}"
                           class="w-full border border-gray-200 rounded-lg pl-10 pr-4 py-2 text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 bg-gray-50">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                </form>
            </div>
        </div>
        <div class="overflow-x-auto rounded-lg">
            <table class="w-full text-sm text-gray-600">
                <thead>
                    <tr class="bg-gray-50 text-gray-700 uppercase text-xs tracking-wider">
                        <th class="px-6 py-4 text-left rounded-tl-lg">ID Pinjaman</th>
                        <th class="px-6 py-4 text-left">Nama Peminjam</th>
                        <th class="px-6 py-4 text-left">Jumlah</th>
                        <th class="px-6 py-4 text-left">Jangka Waktu</th>
                        <th class="px-6 py-4 text-left">Status</th>
                        <th class="px-6 py-4 text-left rounded-tr-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($loanApplications as $loan)
                        <tr class="hover:bg-gray-50 transition-all duration-200">
                            <td class="px-6 py-4">P{{ str_pad($loan->id, 3, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="p-2 bg-indigo-100 rounded-full">
                                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <span>{{ $loan->user->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="p-2 bg-indigo-100 rounded-full">
                                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <span>Rp {{ number_format($loan->amount, 0, ',', '.') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="p-2 bg-indigo-100 rounded-full">
                                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <span>{{ $loan->duration }} Bulan</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusLabels = [
                                        'PENDING' => 'Menunggu',
                                        'APPROVED' => 'Aktif',
                                        'REJECTED' => 'Ditolak'
                                    ];
                                    $statusStyles = [
                                        'PENDING' => 'bg-yellow-100 text-yellow-800',
                                        'APPROVED' => 'bg-teal-100 text-teal-800',
                                        'REJECTED' => 'bg-red-100 text-red-800'
                                    ];
                                    $status = $statusLabels[strtoupper($loan->status)] ?? 'Tidak Diketahui';
                                    $style = $statusStyles[strtoupper($loan->status)] ?? 'bg-gray-100 text-gray-700';
                                @endphp
                                <span class="inline-block {{ $style }} text-xs font-medium px-3 py-1 rounded-full">{{ $status }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <button onclick="openModal('modal-{{ $loan->id }}')"
                                            class="bg-indigo-600 text-white px-3 py-2 rounded-lg text-xs font-medium hover:bg-indigo-700 transition-all duration-200">
                                        Lihat Detail
                                    </button>
                                    @if(strtoupper($loan->status) == 'PENDING')
                                        <form action="{{ route('admin.loan-applications.update-status', $loan->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="APPROVED">
                                            <button type="submit" class="bg-teal-600 text-white px-3 py-2 rounded-lg text-xs font-medium hover:bg-teal-700 transition-all duration-200">
                                                Setujui
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.loan-applications.update-status', $loan->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="REJECTED">
                                            <button type="submit" class="bg-red-600 text-white px-3 py-2 rounded-lg text-xs font-medium hover:bg-red-700 transition-all duration-200">
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

    <!-- Loan Application Modals -->
    @foreach ($loanApplications as $application)
        <div id="modal-{{ $application->id }}" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-xl p-8 max-w-lg w-full modal-content transition-all duration-300 opacity-0 scale-95 shadow-xl">
                <button onclick="closeModal('modal-{{ $application->id }}')"
                        class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 transition-colors duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                <div class="text-center mb-6">
                    <h3 class="text-2xl font-semibold text-gray-800">Detail Pengajuan Pinjaman</h3>
                    <p class="text-sm text-gray-500 mt-1">ID: P{{ str_pad($application->id, 3, '0', STR_PAD_LEFT) }}</p>
                </div>
                <div class="space-y-4 text-sm text-gray-600">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <div>
                            <span class="text-sm font-medium text-gray-700">Nama</span>
                            <p class="text-gray-800">{{ $application->user->name }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <div>
                            <span class="text-sm font-medium text-gray-700">Email</span>
                            <p class="text-gray-800">{{ $application->user->email }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <span class="text-sm font-medium text-gray-700">Jumlah Pinjaman</span>
                            <p class="text-gray-800">Rp {{ number_format($application->amount, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <span class="text-sm font-medium text-gray-700">Jangka Waktu</span>
                            <p class="text-gray-800">{{ $application->duration }} Bulan</p>
                        </div>
                    </div>
                </div>
                <div class="mt-6 text-center">
                    <a href="{{ Storage::url($application->document_path) }}" target="_blank"
                       class="inline-flex items-center text-white bg-indigo-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Lihat Dokumen Pendukung
                    </a>
                </div>
            </div>
        </div>
    @endforeach

    <!-- JavaScript for Modal Control -->
    <script>
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                const modalContent = modal.querySelector('.modal-content');
                setTimeout(() => {
                    modalContent.classList.remove('opacity-0', 'scale-95');
                    modalContent.classList.add('opacity-100', 'scale-100');
                    modal.dataset.isOpen = 'true';
                }, 10);
            }
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal && modal.dataset.isOpen === 'true') {
                const modalContent = modal.querySelector('.modal-content');
                modalContent.classList.remove('opacity-100', 'scale-100');
                modalContent.classList.add('opacity-0', 'scale-95');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.dataset.isOpen = 'false';
                }, 300);
            }
        }

        // Debounced backdrop click handler
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        const handleBackdropClick = debounce(function(event) {
            const modal = event.target.closest('.fixed');
            if (modal && modal.classList.contains('fixed') && !event.target.closest('.modal-content')) {
                closeModal(modal.id);
            }
        }, 100);

        document.addEventListener('click', handleBackdropClick);
    </script>
@endsection
