<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - CreditBlock</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Onest:wght@100..900&display=swap" rel="stylesheet">
    <style>
        body {
            background: #F7FAFC;
            color: #1A202C;
            font-family: 'Onest', sans-serif;
            margin: 0;
            overflow-x: hidden;
        }
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: #FFFFFF;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            z-index: 50;
            border-bottom: 1px solid #EDF2F7;
        }
        .sidebar-fixed {
            position: fixed;
            top: 5rem;
            left: 0;
            height: calc(100vh - 5rem);
            width: 16rem;
            background: #FFFFFF;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
            z-index: 40;
        }
        .sidebar-menu {
            font-size: 0.875rem;
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            color: #4A5568;
            font-weight: 500;
            border-radius: 0.5rem;
        }
        .sidebar-menu:hover {
            background: #F1F5F9;
            color: #1A202C;
            padding-left: 1.75rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        .sidebar-menu-active {
            background: #3182CE;
            color: #FFFFFF;
            padding-left: 1.75rem;
            box-shadow: 0 2px 8px rgba(49, 130, 206, 0.2);
        }
        .sidebar-menu-active:hover {
            background: #2B6CB0;
            color: #FFFFFF;
        }
        .navbar-button {
            background: #3182CE;
            color: #FFFFFF;
            padding: 0.625rem 1.75rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .navbar-button:hover {
            background: #2B6CB0;
            box-shadow: 0 2px 8px rgba(43, 108, 176, 0.2);
        }
        .content-wrapper {
            padding-top: 5rem;
            padding-left: 17rem;
            min-height: 100vh;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        .profile-img {
            width: 3rem;
            height: 3rem;
            border-radius: 9999px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        .profile-img:hover {
            transform: scale(1.05);
        }
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 100;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .modal.show {
            display: flex;
            opacity: 1;
        }
        .modal-content {
            background: linear-gradient(145deg, #FFFFFF, #F7FAFC);
            border-radius: 1rem;
            padding: 2rem;
            width: 100%;
            max-width: 32rem;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15), 0 5px 15px rgba(0, 0, 0, 0.1);
            transform: scale(0.7);
            transition: transform 0.3s ease;
        }
        .modal.show .modal-content {
            transform: scale(1);
        }
        .modal-close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: #EDF2F7;
            border-radius: 50%;
            width: 2rem;
            height: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            cursor: pointer;
            color: #4A5568;
            transition: background 0.2s ease, color 0.2s ease;
        }
        .modal-close:hover {
            background: #E2E8F0;
            color: #1A202C;
        }
        .modal-detail {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            border-radius: 0.5rem;
            background: #F7FAFC;
            transition: background 0.2s ease;
        }
        .modal-detail:hover {
            background: #EDF2F7;
        }
        .modal-detail svg {
            flex-shrink: 0;
        }
        .modal-document-btn {
            background: linear-gradient(to right, #3182CE, #2B6CB0);
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .modal-document-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(49, 130, 206, 0.3);
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        'light-gray': '#F7FAFC',
                        'dark-gray': '#1A202C',
                        'blue-primary': '#3182CE',
                    }
                }
            }
        }
    </script>
</head>
<body class="antialiased">
    <!-- Navbar Fixed -->
    <header class="navbar">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-auto transition-transform hover:scale-105">
                <span class="text-dark-gray font-semibold text-xl tracking-tight">CreditBlock</span>
            </div>
            <div class="flex items-center space-x-6">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <x-auth.responsive-nav-link :href="route('admin.logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-auth.responsive-nav-link>
                </form>
            </div>
        </div>
    </header>

    <!-- Sidebar dan Konten Utama -->
    <div class="flex content-wrapper">
        <!-- Sidebar Fixed -->
        <aside class="sidebar-fixed">
            <div class="mt-6 px-4">
                <div class="flex items-center space-x-3 mb-8">
                    <img src="https://via.placeholder.com/48" alt="Foto Profil" class="profile-img">
                    <div>
                        <span class="text-gray-900 font-semibold text-lg tracking-tight">{{ auth()->user()->name }}</span>
                        <p class="text-gray-500 text-sm">Administrator</p>
                    </div>
                </div>
            </div>
            <nav class="px-4">
                <ul class="space-y-2">
                    @php
                        $icons = [
                            'Dashboard' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>',
                            'Pengguna' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>',
                            'Pinjaman' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
                            'KYC Menunggu' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>',
                            'Kontak Dukungan' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>'
                        ];
                        $activeMenu = request()->routeIs('admin.dashboard') ? 'Dashboard' :
                                     (request()->routeIs('admin.support.*') ? 'Kontak Dukungan' : '');
                        $menuRoutes = [
                            'Dashboard' => 'admin.dashboard',
                            'Pengguna' => '#',
                            'Pinjaman' => '#',
                            'KYC Menunggu' => '#',
                            'Kontak Dukungan' => 'admin.support.index'
                        ];
                    @endphp
                    @foreach ($menuRoutes as $menu => $route)
                        <li>
                            <a href="{{ $route === '#' ? 'javascript:void(0)' : route($route) }}"
                               class="sidebar-menu {{ $activeMenu === $menu ? 'sidebar-menu-active' : '' }}">
                                <span class="mr-3 w-5 {{ $activeMenu === $menu ? 'text-white' : 'text-blue-primary' }}">{!! $icons[$menu] !!}</span>
                                {{ $menu }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>
        </aside>

        <!-- Konten Utama -->
        <main class="flex-1 p-8 bg-light-gray">
            <!-- Card Ringkasan -->
            <div class="grid grid-cols-3 gap-6 mb-10">
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 card-hover transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                    <div class="flex items-center space-x-4">
                        <span class="text-blue-500">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </span>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-1 tracking-wide">Pengguna Aktif</h3>
                            {{-- <p class="text-3xl font-bold text-green-600">{{ $totalUsers }}</p> --}}
                            <p class="text-3xl font-bold text-green-600"></p>
                        </div>
                    </div>
                </div>
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 card-hover transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                    <div class="flex items-center space-x-4">
                        <span class="text-blue-500">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </span>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-1 tracking-wide">Pinjaman Aktif</h3>
                            {{-- <p class="text-3xl font-bold text-green-600">{{ $activeLoans }}</p> --}}
                            <p class="text-3xl font-bold text-green-600"></p>
                        </div>
                    </div>
                </div>
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 card-hover transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                    <div class="flex items-center space-x-4">
                        <span class="text-blue-500">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </span>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-1 tracking-wide">Pengajuan Menunggu</h3>
                            {{-- <p class="text-3xl font-bold text-green-600">{{ $pendingLoans }}</p> --}}
                            <p class="text-3xl font-bold text-green-600"></p>
                        </div>
                    </div>
                </div>
            </div>

<!-- Notifikasi Sukses -->
@if (session('success'))
<div class="mb-6 p-4 bg-green-50 border-l-4 border-green-400 text-green-700 rounded-lg flex items-center">
    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
    </svg>
    {{ session('success') }}
</div>
@endif

<!-- Tabel Pinjaman Aktif -->
<div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 mb-10 transition-all duration-300 card-hover hover:shadow-lg">
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold text-gray-900 tracking-wide leading-relaxed">Pinjaman Aktif</h2>
    <div class="relative w-64">
        <form method="GET" action="{{ route('admin.dashboard') }}">
            <input type="text" name="search" placeholder="Cari nama atau ID..." value="{{ $search ?? '' }}"
                   class="w-full border border-gray-200 rounded-lg pl-10 pr-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300">
            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </span>
        </form>
    </div>
</div>
<div class="overflow-x-auto">
    <table class="w-full text-gray-700 text-sm">
        <thead>
            <tr class="bg-gray-50 text-gray-900">
                <th class="px-6 py-4 text-left rounded-tl-lg font-medium tracking-wide w-24">ID Pinjaman</th>
                <th class="px-6 py-4 text-left font-medium tracking-wide w-56">Nama Peminjam</th>
                <th class="px-6 py-4 text-left font-medium tracking-wide w-40">Jumlah</th>
                <th class="px-6 py-4 text-left font-medium tracking-wide w-32">Jangka Waktu</th>
                <th class="px-6 py-4 text-left font-medium tracking-wide w-32">Status</th>
                <th class="px-6 py-4 text-left rounded-tr-lg font-medium tracking-wide w-64">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($applications as $application)
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition-all duration-200">
                    <td class="px-6 py-4 w-24">P{{ str_pad($application->id, 3, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-6 py-4 w-56">
                        <div class="flex items-center space-x-2">
                            <span class="text-blue-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </span>
                            <span>{{ $application->user->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 w-40">
                        <div class="flex items-center space-x-2">
                            <span class="text-blue-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </span>
                            <span>Rp {{ number_format($application->amount, 0, ',', '.') }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 w-32">
                        <div class="flex items-center space-x-2">
                            <span class="text-blue-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </span>
                            <span>{{ $application->duration }} Bulan</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 w-32">
                        <span class="inline-block text-xs font-medium px-2.5 py-1 rounded-full
                            {{ $application->status == 'APPROVED' ? 'bg-green-100 text-green-700' : ($application->status == 'REJECTED' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                            {{ $application->status == 'APPROVED' ? 'Aktif' : ($application->status == 'REJECTED' ? 'Ditolak' : 'Menunggu') }}
                        </span>
                    </td>
                    <td class="px-6 py-4 w-64 whitespace-nowrap">
                        <div class="flex items-center space-x-2">
                            <button type="button"
                                    onclick="openModal('modal-{{ $application->id }}')"
                                    class="bg-blue-500 text-white px-3 py-1.5 rounded-lg text-xs font-medium tracking-wide transition-all duration-300 hover:bg-blue-600 hover:ring-2 hover:ring-blue-200 hover:ring-opacity-50">
                                Lihat Detail
                            </button>
                            @if ($application->status == 'PENDING')
                                <form action="{{ route('admin.loan-applications.update-status', $application) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="APPROVED">
                                    <button type="submit"
                                            class="bg-blue-900 text-white px-3 py-1.5 rounded-lg text-xs font-medium tracking-wide transition-all duration-300 hover:bg-blue-800">
                                        Setujui
                                    </button>
                                </form>
                                <form action="{{ route('admin.loan-applications.update-status', $application) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="REJECTED">
                                    <button type="submit"
                                            class="bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs font-medium tracking-wide transition-all duration-300 hover:bg-red-700">
                                        Tolak
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada pengajuan pinjaman.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
</div>
<!-- Card KYC Menunggu -->
<div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 transition-all duration-300 card-hover hover:shadow-lg">
    <h2 class="text-xl font-semibold text-gray-900 mb-6 tracking-wide leading-relaxed">Verifikasi KYC</h2>
    <ul class="space-y-4">
        <li class="flex items-center justify-between p-4 bg-gray-50 rounded-lg transition-all duration-200 hover:bg-gray-100">
            <div class="flex items-center space-x-4">
                <span class="text-blue-500">
                    <!-- Ikon Document dari Heroicons -->
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </span>
                <div>
                    <span class="text-gray-900 font-medium text-base">Alice Brown</span>
                    <p class="text-gray-500 text-sm">Uploaded: 25 Mar 2025</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <span class="bg-yellow-100 text-yellow-700 text-xs font-medium px-2.5 py-1 rounded-full">Menunggu</span>
                <button class="bg-blue-500 text-white px-4 py-1.5 rounded-lg text-sm font-medium tracking-wide transition-all duration-300 hover:bg-blue-600 hover:ring-2 hover:ring-blue-200 hover:ring-opacity-50">
                    Verifikasi Sekarang
                </button>
            </div>
        </li>
        <!-- Tambahkan entri lain sesuai kebutuhan -->
    </ul>
</div>

<!-- Modal untuk Setiap Pengajuan -->
@foreach ($applications as $application)
<div id="modal-{{ $application->id }}" class="modal">
    <div class="modal-content">
        <button type="button" class="modal-close" onclick="closeModal('modal-{{ $application->id }}')">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <div class="text-center mb-6">
            <h3 class="text-xl font-bold text-gray-900">Detail Pengajuan Pinjaman</h3>
            <p class="text-sm text-gray-500 mt-1">ID: P{{ str_pad($application->id, 3, '0', STR_PAD_LEFT) }}</p>
        </div>
        <div class="space-y-3">
            <div class="modal-detail">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <div>
                    <span class="text-sm font-medium text-gray-700">Nama</span>
                    <p class="text-gray-900">{{ $application->user->name }}</p>
                </div>
            </div>
            <div class="modal-detail">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                <div>
                    <span class="text-sm font-medium text-gray-700">Email</span>
                    <p class="text-gray-900">{{ $application->user->email }}</p>
                </div>
            </div>
            <div class="modal-detail">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <span class="text-sm font-medium text-gray-700">Jumlah Pinjaman</span>
                    <p class="text-gray-900">Rp {{ number_format($application->amount, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="modal-detail">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
               class="inline-flex items-center modal-document-btn text-white">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Lihat Dokumen Pendukung
            </a>
        </div>
    </div>
</div>
@endforeach
</main>
</div>

<!-- JavaScript untuk Modal -->
<script>
function openModal(modalId) {
const modal = document.getElementById(modalId);
modal.style.display = 'flex';
setTimeout(() => modal.classList.add('show'), 10);
}

function closeModal(modalId) {
const modal = document.getElementById(modalId);
modal.classList.remove('show');
setTimeout(() => modal.style.display = 'none', 300);
}

// Tutup modal saat klik di luar konten
window.onclick = function(event) {
if (event.target.classList.contains('modal')) {
closeModal(event.target.id);
}
}
</script>
</body>
</html>
