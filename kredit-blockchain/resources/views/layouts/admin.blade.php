<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - CreditBlock</title>
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
            background: #FFFFFF;
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
                <div class="flex items-center space-x-3 mb-8">
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
                               class="sidebar-menu {{ $activeMenu === $menu ? 'sidebar-menu-active' : '' }}">
                                <span class="mr-3 w-5 {{ $activeMenu === $menu ? 'text-white' : 'text-blue-primary' }}">{!! $icons[$menu] !!}</span>
                                {{ $menu }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8 bg-light-gray">
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6">
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6">
                    <p>{{ session('error') }}</p>
                </div>
            @endif
            @yield('content')
        </main>
    </div>
</body>
</html>
