<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - CreditBlock</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ethers/5.7.2/ethers.umd.min.js" defer></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        if (typeof ethers === "undefined") {
            document.write('<script src="{{ asset("js/ethers-5.7.2.umd.min.js") }}"><\/script>');
        }
    </script>
    <script src="{{asset('js/dashboard.js')}}" ></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Gaya CSS tetap sama -->
    <style>
        body {
            background: linear-gradient(to bottom, #F0F7FF, #E6F0FA);
            color: #1E3A8A;
            font-family: 'Inter', sans-serif;
            margin: 0;
            overflow-x: hidden;
            position: relative;
        }

        /* Particle Animation */
        .particle {
            position: absolute;
            border-radius: 50%;
            background: rgba(59, 130, 246, 0.3);
            animation: float 15s infinite ease-in-out;
            pointer-events: none;
        }
        .particle-1 { width: 20px; height: 20px; top: 10%; left: 20%; animation-delay: 0s; }
        .particle-2 { width: 15px; height: 15px; top: 50%; left: 70%; animation-delay: 5s; }
        .particle-3 { width: 25px; height: 25px; top: 80%; left: 40%; animation-delay: 10s; }
        @keyframes float {
            0%, 100% { transform: translateY(0) translateX(0); opacity: 0.3; }
            50% { transform: translateY(-50px) translateX(20px); opacity: 0.6; }
        }

        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(59, 130, 246, 0.2);
            box-shadow: 0 4px 20px rgba(59, 130, 246, 0.1);
            z-index: 50;
            animation: fadeIn 0.8s ease-out;
        }

        .sidebar-fixed {
            position: fixed;
            top: 4rem; 
            left: 0;
            height: calc(100vh - 4rem);
            width: 14rem;
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0.15), rgba(59, 130, 246, 0.1));
            backdrop-filter: blur(12px);
            border-right: 1px solid rgba(59, 130, 246, 0.2);
            box-shadow: 2px 0 20px rgba(59, 130, 246, 0.1);
            z-index: 40;
            animation: fadeInUp 0.8s ease-out;
            transition: transform 0.3s ease;
        }

        .sidebar-fixed.hidden {
            transform: translateX(-100%);
        }

        .sidebar-menu {
            font-size: 0.875rem;
            padding: 0.75rem 1.25rem;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            color: #2A9DF4;
            font-weight: 600;
            border-radius: 0.5rem;
            position: relative;
            margin: 0.5rem 0.75rem;
        }

        .sidebar-menu:hover {
            background: rgba(59, 130, 246, 0.15);
            color: #1E3A8A;
            padding-left: 1.75rem;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
            transform: translateX(4px);
        }

        .sidebar-menu-active {
            background: linear-gradient(to right, #2A9DF4, #3B82F6);
            color: #FFFFFF;
            padding-left: 1.75rem;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
            animation: pulse 2s infinite;
        }

        .sidebar-menu-active:hover {
            background: linear-gradient(to right, #2563EB, #1E40AF);
            color: #FFFFFF;
        }

        .navbar-button {
            background: linear-gradient(to right, #2A9DF4, #3B82F6);
            color: #FFFFFF;
            padding: 0.5rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(59, 130, 246, 0.3);
        }

        .navbar-button:hover {
            background: linear-gradient(to right, #2563EB, #1E40AF);
            box-shadow: 0 6px 15px rgba(59, 130, 246, 0.4);
            transform: scale(1.05);
        }

        .navbar-button span {
            position: absolute;
            inset: 0;
            background: #FFFFFF;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .navbar-button:hover span {
            opacity: 0.1;
        }

        .content-wrapper {
            padding-top: 4rem; 
            padding-left: 14.5rem; 
            min-height: 100vh;
            background: transparent;
            transition: padding-left 0.3s ease;
        }

        .content-wrapper.sidebar-hidden {
            padding-left: 0;
            padding-top: 4rem;
        }

        .profile-img { 
            width: 2.75rem; /* 44px */
            height: 2.75rem; /* 44px */
            border-radius: 9999px;
            object-fit: cover;
            transition: transform 0.3s ease;
            border: 2px solid rgba(59, 130, 246, 0.3);
            cursor: pointer; 
        }

        .profile-img:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .tooltip {
            position: absolute;
            top: -2.25rem;
            left: 50%;
            transform: translateX(-50%);
            background: #2563EB;
            color: #FFFFFF;
            font-size: 0.75rem;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            opacity: 0;
            pointer-events: none;
            transition: all 0.3s ease;
            white-space: nowrap;
            animation: slideUp 0.5s ease-out;
        }

        .sidebar-menu:hover .tooltip {
            opacity: 1;
            top: -2.75rem;
        }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            color: #2A9DF4;
            font-size: 1.5rem;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .menu-toggle:hover {
            color: #2563EB;
        }

        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }

        @media (max-width: 768px) {
            .sidebar-fixed {
                transform: translateX(-100%);
                top: 0;
                height: 100vh;
                z-index: 60; /* Above navbar on mobile */
            }
            .sidebar-fixed.active {
                transform: translateX(0);
            }
            .content-wrapper {
                padding-left: 0;
                padding-top: 4rem;
            }
            .menu-toggle {
                display: block;
            }
            .navbar {
                z-index: 70; /* Ensure navbar stays above sidebar */
            }
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
                        'light-gray': '#F0F7FF',
                        'dark-blue': '#1E3A8A',
                        'blue-primary': '#2A9DF4',
                        'blue-hover': '#2563EB',
                    }
                }
            }
        }
    </script>
</head>
<body class="antialiased">
    <!-- Particle Animation -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="particle particle-1"></div>
        <div class="particle particle-2"></div>
        <div class="particle particle-3"></div>
    </div>

    <!-- Navbar -->
    <header class="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <button class="menu-toggle" onclick="toggleSidebar()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <img src="{{ asset('images/logoCB.png') }}" alt="Logo" class="h-7 w-auto transition-transform duration-300 hover:scale-110 hover:drop-shadow-[0_4px_12px_rgba(59,130,246,0.3)]">
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="navbar-button">
                    <span></span>
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </header>

    <!-- Modal untuk Mengganti Foto Profil -->
    <div id="profile-modal" class="fixed z-50 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Ubah Foto Profil
                            </h3>
                            <div class="mt-2">
                                <form id="profile-form" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="modal-profile-picture" class="block text-gray-700 text-sm font-bold mb-2">Foto Profil</label>
                                        <img id="modal-current-profile-picture" src="" alt="Current Profile Picture" class="rounded-full h-32 w-32 object-cover mb-4">
                                        <input type="file" name="profile_picture" id="modal-profile-picture" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                        <div id="modal-profile-picture-error" class="text-red-500 text-xs italic"></div>
                                        <div class="mt-4">
                                            <p class="text-gray-700 font-medium">Nama: {{ auth()->check() ? auth()->user()->name : 'Guest' }}</p>
                                            <p class="text-gray-600 text-sm">Email: {{ auth()->check() ? auth()->user()->email : 'guest@example.com' }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-end">
                                        <button type="button" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2" id="close-profile-modal">
                                            Batal
                                        </button>
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                            Simpan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Wrapper -->
    <div class="flex content-wrapper relative">
        <aside class="sidebar-fixed" id="sidebar">
            <div class="mt-6 px-4">
                <div class="flex items-center space-x-3 mb-10">
                    <img id="sidebar-profile-image"
                         src="{{ Auth::user()->profile_picture ? asset('storage/profile_pictures/' . Auth::user()->profile_picture) : asset('images/man.png') }}"
                         alt="Foto Profil"
                         class="profile-img"
                         title="Ubah Foto Profil">
                         <div>
                            <span class="text-blue-800 font-bold text-base tracking-tight">{{ auth()->check() ? auth()->user()->name : 'Guest' }}</span>
                            <p class="text-blue-600 text-xs font-medium">{{ auth()->check() ? 'Pengguna' : 'Tamu' }}</p>
                        </div>
                </div>
            </div>
            <nav class="px-4">
                <ul class="space-y-1">
                    @php
                        $icons = [
                            'Dashboard' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>',
                            'Ajukan Pinjaman' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
                            'Riwayat Peminjaman' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>',
                            'Profil' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>',
                            'Riwayat Pembayaran' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
                            'Kontak Dukungan' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>',
                            'Pembayaran Cicilan' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
                        
                        ];
                        $activeMenu = '';
                        $currentRouteName = request()->route()->getName();
                        if ($currentRouteName === 'dashboard') $activeMenu = 'Dashboard';
                        elseif ($currentRouteName === 'loan-applications.create') $activeMenu = 'Ajukan Pinjaman';
                        elseif ($currentRouteName === 'payments.create') $activeMenu = 'Pembayaran Cicilan';
                        elseif ($currentRouteName === 'payments.history') $activeMenu = 'Riwayat Pembayaran';
                        elseif ($currentRouteName === 'loan-applications.index') $activeMenu = 'Riwayat Peminjaman';
                        elseif ($currentRouteName === 'support.index') $activeMenu = 'Kontak Dukungan';
                        $menuRoutes = [
                            'Dashboard' => 'dashboard',
                            'Ajukan Pinjaman' => 'loan-applications.create',
                            'Riwayat Peminjaman' => 'loan-applications.index',
                            'Profil' => null,
                            'Pembayaran Cicilan' => 'payments.create',
                            'Riwayat Pembayaran' => 'payments.history',
                            'Kontak Dukungan' => 'support.index'
                        ];
                    @endphp
                    @foreach ($menuRoutes as $menu => $route)
                        <li>
                            <a href="{{ $route ? route($route) : 'javascript:void(0)' }}"
                               @if ($menu === 'Profil') id="sidebar-profile-link" @endif
                               class="sidebar-menu {{ $activeMenu === $menu ? 'sidebar-menu-active' : '' }}"
                               @if ($menu === 'Profil') title="Ubah Foto Profil" @endif>
                                <span class="mr-3 w-5 {{ $activeMenu === $menu ? 'text-white' : 'text-blue-primary' }}">{!! $icons[$menu] !!}</span>
                                {{ $menu }}
                                <span class="tooltip">{{ $menu }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>
        </aside>

        <main class="flex-1 p-6 sm:p-8 bg-transparent">
            @yield('content')
        </main>
    </div>

    <!-- JavaScript untuk Modal -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil elemen DOM yang dibutuhkan
            const openProfileModalButton = document.getElementById('open-profile-modal'); // Gambar profil di dashboard
            const sidebarProfileImage = document.getElementById('sidebar-profile-image'); // Gambar profil di sidebar
            const sidebarProfileLink = document.getElementById('sidebar-profile-link'); // Link 'Profil' di sidebar
            const profileModal = document.getElementById('profile-modal');
            const closeProfileModalButton = document.getElementById('close-profile-modal');
            const profileForm = document.getElementById('profile-form');
            const currentProfilePicture = document.getElementById('modal-current-profile-picture');
            const profilePictureInput = document.getElementById('modal-profile-picture');
            const profilePictureError = document.getElementById('modal-profile-picture-error');

            // Fungsi untuk membuka modal
            const openModal = () => {
                // Ambil data user dari server
                fetch('/profile/edit')
                    .then(response => response.json())
                    .then(data => {
                        // Set gambar profil yang ada (atau default)
                        if (data.user.profile_picture) {
                            currentProfilePicture.src = `/storage/profile_pictures/${data.user.profile_picture}`;
                        } else {
                            currentProfilePicture.src = '/images/man.png';
                        }
                        // Tampilkan modal
                        profileModal.classList.remove('hidden');
                    })
                    .catch(error => {
                        console.error('Error fetching profile:', error);
                        alert('Gagal memuat data profil.');
                    });
            };

            // Event listener untuk gambar profil di sidebar
            if (sidebarProfileImage) {
                sidebarProfileImage.addEventListener('click', openModal);
            }

            // Event listener untuk link 'Profil' di sidebar
            if (sidebarProfileLink) {
                sidebarProfileLink.addEventListener('click', openModal);
            }

            // Event listener untuk gambar profil di dashboard (jika ada)
            if (openProfileModalButton) {
                openProfileModalButton.addEventListener('click', openModal);
            }

            // Fungsi untuk menutup modal
            if (closeProfileModalButton) {
                closeProfileModalButton.addEventListener('click', () => {
                    profileModal.classList.add('hidden');
                    profilePictureError.textContent = '';
                    profileForm.reset();
                });
            }

            // Fungsi untuk menangani submit form
            if (profileForm) {
                profileForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    const formData = new FormData(profileForm);

                    fetch('/profile/update', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.errors) {
                            profilePictureError.textContent = data.errors.profile_picture ? data.errors.profile_picture[0] : '';
                        } else if (data.message) {
                            alert(data.message);
                            if (data.profile_picture) {
                                // Update gambar di dashboard (jika ada)
                                if (openProfileModalButton) {
                                    openProfileModalButton.src = data.profile_picture;
                                }
                                // Update gambar di sidebar
                                if (sidebarProfileImage) {
                                    sidebarProfileImage.src = data.profile_picture;
                                }
                                currentProfilePicture.src = data.profile_picture;
                            }
                            profileModal.classList.add('hidden');
                            profilePictureError.textContent = '';
                            profileForm.reset();
                        } else if (data.error) {
                            alert(data.error);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Gagal memperbarui foto profil.');
                    });
                });
            }

            // Fungsi untuk toggle sidebar (tetap sama)
            function toggleSidebar() {
                const sidebar = document.getElementById('sidebar');
                const contentWrapper = document.querySelector('.content-wrapper');
                sidebar.classList.toggle('active');
                sidebar.classList.toggle('hidden');
                if (contentWrapper) {
                    contentWrapper.classList.toggle('sidebar-hidden');
                }
            }
        });
    </script>
</body>
</html>