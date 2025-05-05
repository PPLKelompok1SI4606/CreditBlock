<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - CreditBlock</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom, #F0F7FF, #E5E7EB);
            color: #1A202C;
            font-family: 'Inter', sans-serif;
            margin: 0;
            overflow-x: hidden;
        }
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            z-index: 50;
            border-bottom: 1px solid rgba(229, 231, 235, 0.3);
        }
        .sidebar-fixed {
            position: fixed;
            top: 5rem;
            left: 0;
            height: calc(100vh - 5rem);
            width: 16rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 2px 0 15px rgba(0, 0, 0, 0.05);
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
            background: rgba(59, 130, 246, 0.1);
            color: #1A202C;
            padding-left: 1.75rem;
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.15);
        }
        .sidebar-menu-active {
            background: linear-gradient(to right, #3B82F6, #2A9DF4);
            color: #FFFFFF;
            padding-left: 1.75rem;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }
        .sidebar-menu-active:hover {
            background: linear-gradient(to right, #2563EB, #1D4ED8);
            color: #FFFFFF;
        }
        .navbar-button {
            background: linear-gradient(to right, #3B82F6, #2A9DF4);
            color: #FFFFFF;
            padding: 0.625rem 1.75rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .navbar-button:hover {
            background: linear-gradient(to right, #2563EB, #1D4ED8);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
            transform: scale(1.05);
        }
        .navbar-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .navbar-button:hover::before {
            opacity: 1;
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
            border: 2px solid #E5E7EB;
        }
        .profile-img:hover {
            transform: scale(1.05);
            border-color: #3B82F6;
        }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
            z-index: 1000;
            transition: opacity 0.3s ease;
        }
        .modal.show {
            opacity: 1;
        }
        .modal-content {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 0.5rem;
            padding: 1.5rem;
            width: 100%;
            max-width: 32rem;
            position: relative;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        .modal-close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: none;
            border: none;
            cursor: pointer;
            color: #4A5568;
            transition: color 0.3s ease;
        }
        .modal-close:hover {
            color: #1A202C;
        }
        /* Animasi Partikel */
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
        /* Animasi Fade-In */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.8s ease-out;
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        inter: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        'light-blue': '#F0F7FF',
                        'dark-gray': '#1A202C',
                        'blue-primary': '#3B82F6',
                        'blue-secondary': '#2A9DF4',
                    }
                }
            }
        }
    </script>
</head>
<body class="antialiased relative">
    <!-- Animasi Partikel Latar -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="particle particle-1"></div>
        <div class="particle particle-2"></div>
        <div class="particle particle-3"></div>
    </div>

    <!-- Navbar -->
    <header class="navbar">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <img src="{{asset('images/logoCB.png')}}" alt="Logo" class="h-10 w-auto transition-transform hover:scale-105">
            </div>
            <div class="flex items-center space-x-6">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="navbar-button">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Sidebar dan Konten -->
    <div class="flex content-wrapper">
        <!-- Sidebar -->
        <aside class="sidebar-fixed">
            <div class="mt-6 px-4">
                <div class="flex items-center space-x-3 mb-8 animate-fade-in">
                    <img src="https://via.placeholder.com/48" alt="Foto Profil" class="profile-img">
                    <div>
                        <span class="text-gray-900 font-semibold text-lg tracking-tight">{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</span>
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
                        $menuRoutes = [
                            'Dashboard' => 'admin.dashboard',
                            'Pengguna' => '#',
                            'Pinjaman' => 'admin.loan-applications',
                            'KYC Menunggu' => '#',
                            'Kontak Dukungan' => 'admin.support.index'
                        ];
                        $activeMenu = match (true) {
                            request()->routeIs('admin.dashboard') => 'Dashboard',
                            request()->routeIs('admin.loan-applications') => 'Pinjaman',
                            request()->routeIs('admin.support.*') => 'Kontak Dukungan',
                            default => ''
                        };
                    @endphp
                    @foreach (['Dashboard', 'Pengguna', 'Pinjaman', 'KYC Menunggu', 'Kontak Dukungan'] as $menu)
                        <li>
                            <a href="{{ isset($menuRoutes[$menu]) && $menuRoutes[$menu] !== '#' ? route($menuRoutes[$menu]) : '#' }}"
                               class="sidebar-menu {{ $activeMenu === $menu ? 'sidebar-menu-active' : '' }} group animate-fade-in">
                                <span class="mr-3 w-5 {{ $activeMenu === $menu ? 'text-white' : 'text-blue-primary group-hover:text-blue-secondary' }} transition-colors duration-300">{!! $icons[$menu] !!}</span>
                                {{ $menu }}
                                <span class="absolute hidden group-hover:block -right-8 top-1/2 transform -translate-y-1/2 bg-blue-600 text-white text-xs rounded py-1 px-2 animate-slide-up">{{ $menu }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8 bg-transparent relative">
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6 flex items-center animate-pulse">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 flex items-center animate-pulse">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <p>{{ session('error') }}</p>
                </div>
            @endif
            @yield('content')
        </main>
    </div>
</body>
</html>
