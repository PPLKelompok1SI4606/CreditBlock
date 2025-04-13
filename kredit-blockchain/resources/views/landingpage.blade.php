<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Landing Page</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="flex flex-col justify-center items-center m-0 p-0">

    <div class="h-[850px]">
        {{-- Navbar --}}
        <section class="flex items-center justify-between w-full h-[80px]">
            <img src="{{asset('images/logoCB.png')}}" alt="" class="flex justify-start">
            <div>
                <x-landingpage.nav-item></x-landingpage.nav-item>
            </div>
            <div class="ml-3">
                <x-landingpage.auth-button></x-landingpage.auth-button>
            </div>
        </section>
        {{-- Navbar End --}}

        <div class="w-full h-[1px] bg-[#c7e7ff]"></div>

        {{-- Hero --}}
        <section class="flex justify-center items-center w-full h-[684px]">
            <x-landingpage.hero></x-landingpage.hero>
        </section>
        {{-- Hero End --}}


        <img src="{{asset('images/bgBlur.png')}}" alt="" class="absolute left-0 top-60 -z-10">
        <img src="{{asset('images/bgNonBlur.png')}}" alt="" class="absolute right-0 top-60 -z-10">

    </div>

    {{-- Collaborated --}}
    <section class="flex flex-col items-center justify-center w-full h-[300px] px-[100px] bg-[#D0EFFF]">

        <h1 class="text-[#2A9DF4] font-bold text-lg tracking-widest">COLLABORATED WITH</h1>
        <div class="inline-flex items-center justify-center mt-10 gap-x-[130px]">
            <x-landingpage.bank-logo></x-landingpage.bank-logo>

        </div>

    </section>

    {{-- Kenapa Memilih Kami --}}
    <section class="flex flex-col items-center w-full h-[1200px] px-[100px] mt-[90px] relative">
        <h1 class="text-[#2A9DF4] font-semibold tracking-widest text-xl">PILIH CREDITBLOCK</h1>
        <h1 class="text-[#1167B1] font-bold tracking-widest text-4xl mt-2">KENAPA MEMILIH KAMI?!</h1>

        <div class="grid grid-cols-2 gap-6 mt-10 items-center justify-center">

            <x-landingpage.grid-column>
                <h1 class="font-bold text-2xl">PROSES PENGAJUAN CEPAT</h1>
                <div class="inline-flex mt-3 gap-x-[50px]">
                    <img src="{{asset('images/01.png')}}" alt="" class="mt-[108px]">
                    <p class="mt-10">Isi form super singkat, langsung dapat dana! Tidak perlu antri atau ribet dokumen – cair lebih cepat dari kopi pagimu.</p>
                </div>
            </x-landingpage.grid-column>

            <x-landingpage.grid-column>
                <h1 class="font-bold text-2xl">TRANSPARANSI BLOCKCHAIN</h1>
                <div class="inline-flex mt-3 gap-x-[50px]">
                    <img src="{{asset('images/01.png')}}" alt="" class="mt-[108px]">
                    <p class="mt-10">Isi form super singkat, langsung dapat dana! Tidak perlu antri atau ribet dokumen – cair lebih cepat dari kopi pagimu.</p>
                </div>
            </x-landingpage.grid-column>

            <x-landingpage.grid-column >
                <h1 class="font-bold text-2xl">DASHBOARD PRIBADI</h1>
                <div class="inline-flex mt-3 gap-x-[50px]">
                    <p class="mt-10">Isi form super singkat, langsung dapat dana! Tidak perlu antri atau ribet dokumen – cair lebih cepat dari kopi pagimu.</p>
                    <img src="{{asset('images/01.png')}}" alt="" class="mt-[108px]">
                </div>
            </x-landingpage.grid-column>

            <x-landingpage.grid-column>
                <h1 class="font-bold text-2xl">NOTIFIKASI JATUH TEMPO</h1>
                <div class="inline-flex mt-3 gap-x-[50px]">
                    <p class="mt-10">Isi form super singkat, langsung dapat dana! Tidak perlu antri atau ribet dokumen – cair lebih cepat dari kopi pagimu.</p>
                    <img src="{{asset('images/01.png')}}" alt="" class="mt-[108px]">
                </div>
            </x-landingpage.grid-column>


        </div>
        <div class="flex mt-[25px] flex-col w-[600px] px-8 py-5 h-[300px] rounded-4xl border-2 border-gray-300 bg-[#c7e7ff]">
            <h1 class="font-bold text-2xl">KALKULATOR CICILAN</h1>
            <div class="inline-flex mt-3 gap-x-[50px]">
                <img src="{{asset('images/01.png')}}" alt="" class="mt-[108px]">
                <p class="mt-10">Isi form super singkat, langsung dapat dana! Tidak perlu antri atau ribet dokumen – cair lebih cepat dari kopi pagimu.</p>
            </div>
        </div>

        <img src="{{asset('images/bg-circle.png')}}" alt="" class="absolute left-0 mt-[100px] -z-10 bottom-0 w-[800px]">
        <div class="absolute right-0 w-[200px] h-[400px] rounded-l-full bg-[#94CEF9] -z-10">

        </div>
    </section>



</body>
</html>
