<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Login') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="{{asset('css/landingpage.css')}}">
        <script defer src="{{ asset('js/landingpage.js') }}"></script>

        <!-- Tambahkan CDN SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900">
        <div class="flex min-h-screen">
            <div class="relative flex w-1/2 flex-col items-center justify-center">
                <x-background class="absolute bg-cover bg-center h-full w-full text-gray-500" />
                <x-application-logo class="z-10"></x-application-logo>
                <a href="{{route('landingpage')}}" class="z-50">
                    <x-icon class="z-10 h-[380px] mt-10 transition duration-300 ease-in-out hover:-translate-y-1"></x-icon>
                </a>
                <h1 class="z-10 mt-10 font-bold text-center text-2xl text-[#1167B1] w-[500px] ">Credit Dompet Aman dengan Blockchain untuk Semuanya</h1>
                <p class="z-10 text-center mt-5 text-[#1167B1] w-[500px] ">CreditBlock adalah sebuah aplikasi berbasis website yang bisa mengamankan dompet digital Anda dengan menggunakan teknologi blockchain.</p>
            </div>

            <div class="flex-1 h-screen flex flex-col items-center justify-center hidden-animated">
                {{ $slot }}
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {

                @if (session('status'))
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: '{{ session('status') }}',
                        confirmButtonText: 'OK'
                    });
                @endif

                @if (session('error'))
                    Swal.fire({
                        icon: 'warning',
                        title: 'Gagal🥺',
                        text: '{{ session('error') }}',
                        confirmButtonText: 'OK'
                    });
                @endif
            });
        </script>
    </body>
</html>
