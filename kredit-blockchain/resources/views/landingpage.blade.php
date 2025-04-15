<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Landing Page</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="{{asset('css/landingpage.css')}}">
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
        <div class="overflow-hidden mt-10">
            <div class="marquee ">
                <!-- Konten asli -->
                <div class="inline-flex items-center justify-center gap-x-[130px]">
                    <img src="images/bi_logo.png" alt="BI Logo" class="h-12">
                    <img src="images/bri_logo.png" alt="BRI Logo" class="h-12">
                    <img src="images/logo_BCA_Biru.png" alt="BCA Logo" class="h-12">
                    <img src="images/mandiri_logo.png" alt="Mandiri Logo" class="h-12">
                    <img src="images/ojk_logo.png" alt="OJK Logo" class="h-12">
                </div>

            </div>
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
                    <img src="{{asset('images/02.png')}}" alt="" class="mt-[108px]">
                    <p class="mt-10">Setiap transaksi tercatat abadi di blockchain – tidak bisa dimanipulasi atau "kecurangan administrasi".</p>
                </div>
            </x-landingpage.grid-column>

            <x-landingpage.grid-column >
                <h1 class="font-bold text-2xl">DASHBOARD PRIBADI</h1>
                <div class="inline-flex mt-3 gap-x-[50px]">
                    <p class="mt-10">Pantau pinjaman, cicilan, dan riwayat pembayaran semudah cek media sosial – semua rapi dalam satu layar.</p>
                    <img src="{{asset('images/03.png')}}" alt="" class="mt-[108px]">
                </div>
            </x-landingpage.grid-column>

            <x-landingpage.grid-column>
                <h1 class="font-bold text-2xl">NOTIFIKASI JATUH TEMPO</h1>
                <div class="inline-flex mt-3 gap-x-[50px]">
                    <p class="mt-10">Sistem kami akan ingatkan Anda sebelum jatuh tempo – seperti asisten pribadi yang selalu on time.</p>
                    <img src="{{asset('images/04.png')}}" alt="" class="mt-[108px]">
                </div>
            </x-landingpage.grid-column>


        </div>
        <div class="flex mt-[25px] flex-col w-[600px] px-8 py-5 h-[300px] rounded-4xl border-2 border-gray-300 bg-[#c7e7ff] transition duration-300 ease-in-out hover:-translate-y-1 hover:shadow-xl">
            <h1 class="font-bold text-2xl">KALKULATOR CICILAN</h1>
            <div class="inline-flex mt-3 gap-x-[50px]">
                <img src="{{asset('images/05.png')}}" alt="" class="mt-[108px]">
                <p class="mt-10">Rencanakan pinjaman dengan percaya diri – tahu persis berapa yang harus dibayar sebelum mengajukan!</p>
            </div>
        </div>

        <img src="{{asset('images/bg-circle.png')}}" alt="" class="absolute left-0 mt-[100px] -z-10 bottom-0 w-[800px]">
        <div class="absolute right-0 w-[200px] h-[400px] rounded-l-full bg-[#94CEF9] -z-10">

        </div>
    </section>

    {{-- Langkah Mudah --}}
    <section class="flex flex-col items-center w-full h-full px-[100px] mt-[20px] relative mb-10">
        <h1 class="text-[#2A9DF4] font-semibold tracking-widest text-xl">LANGKAH MUDAH</h1>
        <h1 class="text-[#1167B1] font-bold text-5xl mt-2 tracking-wide">Langkah Mudah Mendapatkan Pinjaman</h1>

        <div class="w-[1100px] px-10 py-10 h-full border border-gray-300 rounded-xl mt-10 backdrop-blur-md">

            <x-landingpage.easy-step>

                <h1 class="font-bold text-lg text-[#2A9DF4]">01.</h1>
                <div class="flex flex-col w-full h-full ml-10">
                    <h1 class="font-semibold text-xl">Daftar dengan E-mail dan Kata Sandi</h1>
                    <p class="mt-3 text-sm">
                        Dana cair lebih cepat dari kopi pagimu! Cukup masukkan email dan buat sandi sederhana - prosesnya hanya 30 detik saja. Kami langsung mengirimkan email verifikasi untuk memastikan keamanan akun Anda. Setelah klik link verifikasi, Anda langsung masuk ke dashboard pribadi yang siap digunakan. Lebih praktis dari membuat akun media sosial, dan yang pasti lebih menguntungkan!
                    </p>
                </div>

            </x-landingpage.easy-step>

            <div class="w-full border my-10"></div>

            <x-landingpage.easy-step>

                <h1 class="font-bold text-lg text-[#2A9DF4]">02.</h1>
                <div class="flex flex-col w-full h-full ml-10">
                    <h1 class="font-semibold text-xl">Ajukan Pinjaman dengan Form Sederhana</h1>
                    <p class="mt-3 text-sm">
                        Raih dana yang Anda butuhkan tanpa ribet! Formulir kami super sederhana - hanya butuh 3 informasi utama dengan desain slider yang mudah digunakan. Tentukan sendiri jumlah pinjaman dan jangka waktu yang nyaman untuk dompet Anda. Semua perhitungan langsung terlihat transparan di depan mata, tanpa biaya tersembunyi yang mengejutkan. Tinggal tekan 'Ajukan' dan biarkan sistem cerdas kami bekerja untuk kesuksesan finansial Anda!
                    </p>
                </div>

            </x-landingpage.easy-step>

            <div class="w-full border my-10"></div>

            <x-landingpage.easy-step>

                <h1 class="font-bold text-lg text-[#2A9DF4]">03.</h1>
                <div class="flex flex-col w-full h-full ml-10">
                    <h1 class="font-semibold text-xl">Unggah Dokumen Pendukung (KYC/Slip Gaji)</h1>
                    <p class="mt-3 text-sm">
                        Verifikasi kilat tanpa harus keluar rumah! Proses KYC kami cepat dan aman dengan teknologi enkripsi mutakhir - cukup foto KTP dan selfie sederhana. Untuk pinjaman lebih besar, tambahkan slip gaji atau bukti penghasilan dengan sekali unggah saja. Dokumen Anda kami jamin kerahasiaannya dan hanya digunakan untuk verifikasi. Tidak perlu antri di bank atau repot fotokopi dokumen fisik yang merepotkan!
                    </p>
                </div>

            </x-landingpage.easy-step>

            <div class="w-full border my-10"></div>

            <x-landingpage.easy-step>

                <h1 class="font-bold text-lg text-[#2A9DF4]">04.</h1>
                <div class="flex flex-col w-full h-full ml-10">
                    <h1 class="font-semibold text-xl">Pantau Status di Dashboard</h1>
                    <p class="mt-3 text-sm">
                        Kontrol penuh di genggaman tangan Anda! Dashboard canggih kami memberikan update real-time setiap tahap proses, seperti melacak paket online favorit Anda. Dapatkan notifikasi instan saat pinjaman disetujui dan dana siap cair. Semua informasi cicilan disajikan dalam grafik interaktif yang mudah dimengerti. Akses kapan saja, di mana saja - bahkan saat sedang bepergian sekalipun!
                    </p>
                </div>

            </x-landingpage.easy-step>

            <div class="w-full border my-10"></div>

            <x-landingpage.easy-step>

                <h1 class="font-bold text-lg text-[#2A9DF4]">05.</h1>
                <div class="flex flex-col w-full h-full ml-10">
                    <h1 class="font-semibold text-xl">Bayar Cicilan Via Wallet Blockchain</h1>
                    <p class="mt-3 text-sm">
                        Pembayaran semudah belanja online! Lakukan cicilan kapan saja melalui integrasi dengan wallet digital favorit Anda. Pilih metode pembebasan yang paling nyaman dari berbagai opsi pembayaran modern. Setiap transaksi tercatat abadi di blockchain untuk jaminan transparansi mutlak. Kami bahkan akan mengingatkan Anda sebelum jatuh tempo - jadi tak perlu khawatir terlambat bayar. Riwayat lengkap selalu tersedia untuk kebutuhan keuangan Anda!
                    </p>
                </div>

            </x-landingpage.easy-step>

        </div>

        <img src="{{asset('images/bgNonBlur.png')}}" alt="" class="absolute right-0 top-80 -z-20">

        <a href="{{route('dashboard')}}" class="my-[50px]">
            <button class="inline-flex h-full items-center px-[150px] py-4 text-[20px] text-white font-bold shadow-xl rounded-full bg-blue-300 transition duration-300 ease-in-out hover:-translate-y-1 hover:scale-105">
                Pelajari Lebih Lanjut
                <img src="{{asset('images/arrow.png')}}" alt="" class="w-[15px] h-[15px] ml-3 ">
            </button>
        </a>

        <img src="{{asset('images/cirlcebg.png')}}" class="absolute left-0 top-200 -z-20" alt="">
    </section>

    {{-- Loan Calculator --}}
    <section class="flex flex-col items-center w-full h-full px-[100px] py-10 text-center">
        <h1 class="text-[#2A9DF4] font-semibold tracking-widest text-lg">LOAN CALCULATOR</h1>
        <h1 class="text-[40px] w-[900px] tracking-widest font-bold text-[#1167B1]">Hitung Cicilanmu Sekarang & Temukan Cara Lebih Ringan untuk Membayar!</h1>

        <div class="flex flex-col items-center px-10 py-10 bg-white mt-10 rounded-xl border h-full border-gray-300 shadow-blue-300 shadow-xl ">

            <div class="flex flex-col items-start">
                <p class="text-[#1167B1] font-semibold "><span class="mr-3">1.</span> Jumlah Pinjaman yang akan diajukan</p>
                <p class="text-gray-500">Maksimal pengajuan pinjaman adalah <span><span class="text-red-500">Rp100.000.000</span></span></p>
                <div class="my-5 inline-flex w-[650px] h-[50px]">
                    <p class="flex items-center border border-r-0 border-gray-300 rounded-l-lg w-[400px] h-full pl-5">Jumlah Pinjaman</p>
                    <p class="flex items-center border border-r-0 border-l-0 border-gray-300 w-[45px] h-full pl-5">Rp.</p>
                    <input type="text" class="flex border-l-0 rounded-r-lg w-[250px] h-full border border-gray-300 ring-0 focus:ring-0" placeholder="Masukkan jumlah pinjaman">
                </div>
            </div>

            <div class="flex flex-col items-start">
                <p class="text-[#1167B1] font-semibold"><span class="mr-3">2.</span> Lama Pinjaman yang Akan Diajukan</p>
                <p class="text-gray-500">Masukkan pinjaman dalam jangka waktu bulan.</p>
                <div class="my-5 inline-flex w-[650px] h-[50px]">
                    <p class="flex items-center border border-r-0 border-gray-300 rounded-l-lg w-[250px] h-full pl-5">Jumlah Pinjaman</p>
                    <input type="text" class="flex text-center border-l-0 border-r-0 w-[150px] h-full border border-gray-300 ring-0 focus:ring-0" placeholder="Masukkan Bulan">
                    <p class="flex items-center justify-end border border-l-0 border-gray-300 rounded-r-lg w-[250px] h-full pr-5">Bulan</p>
                </div>
            </div>

            <div class="flex flex-col items-start">
                <p class="text-[#1167B1] font-semibold"><span class="mr-3">2.</span> Lama Pinjaman yang Akan Diajukan</p>
                <p class="text-gray-500">Masukkan pinjaman dalam jangka waktu bulan.</p>
                <div class="my-5 inline-flex w-[650px] h-[50px]">
                    <p class="flex items-center border border-r-0 border-gray-300 rounded-l-lg w-[250px] h-full pl-5">Bunga Pinjaman</p>
                    <input type="text" class="flex text-center border-l-0 border-r-0 w-[150px] h-full border border-gray-300 ring-0 focus:ring-0" placeholder="Masukkan Persen">
                    <p class="flex items-center justify-end border border-l-0 border-gray-300 rounded-r-lg w-[250px] h-full pr-5">%</p>
                </div>
            </div>

            <div class="flex flex-col items-start">
                <p class="text-[#1167B1] font-semibold"><span class="mr-3">2.</span> Lama Pinjaman yang Akan Diajukan</p>
                <p class="text-gray-500">Masukkan pinjaman dalam jangka waktu bulan.</p>

                <div class="flex justify-between w-[650px] h-[50px]">

                    <x-landingpage.option-month></x-landingpage.option-month>

                    <x-landingpage.option-year></x-landingpage.option-year>

                </div>

                <p class="mt-10 font-bold">Sampai Dengan :</p>

                <div class="flex justify-between w-[650px] h-[50px]">
                    <x-landingpage.option-month></x-landingpage.option-month>

                    <x-landingpage.option-year></x-landingpage.option-year>
                </div>

            </div>

            <a href="{{route('dashboard')}}" class="mt-[80px] mb-4">
                <button
                    type="submit"
                    class="px-[200px] py-4 bg-[#1167B1] text-white rounded-xl border transition duration-300 ease-in-out hover:-translate-y-1 hover:scale-105">
                    Hitung
                </button>
            </a>

            <p class="text-center tracking-wider w-[500px] text-gray-500">Anda dapat mesimulasikan cicilan yang akan dipinjam dengan tepat!</p>

        </div>

    </section>

    {{-- FAQ --}}
    <section class="relative flex flex-col items-center my-[100px] justify-center w-full h-full px-[100px]">

        <div
            class="absolute w-full h-[400px] blur-[90px] bg-blue-100 top-50 -z-20">
        </div>

        <h1 class="text-[#2A9DF4] font-semibold tracking-widest text-xl">FAQ</h1>
        <h1 class="text-[#1167B1] font-bold text-5xl mt-2 tracking-wide">Frequently Asked Questions</h1>

        <div class="w-[1000px] h-full py-5 px-7 border-2 bg-white border-gray-400 rounded-xl mt-10">
            <div class="inline-flex w-full justify-between mb-10">
                <h1 class=" text-[#1167B1] font-bold text-xl tracking-wide">Apa itu Wallet Blockchain ?</h1>
                <img src="{{asset('images/-.png')}}" alt="">
            </div>
            <p class="text-gray-500">Wallet blockchain adalah dompet digital khusus yang digunakan untuk menyimpan dan mengelola aset kripto. Dalam konteks layanan kami, wallet ini berfungsi sebagai sarana untuk menerima dana pinjaman, melakukan pembayaran cicilan, serta memantau seluruh riwayat transaksi yang tercatat secara permanen di jaringan blockchain. Bagi pengguna baru yang belum familiar, kami menyediakan panduan lengkap mulai dari cara membuat wallet hingga tutorial penggunaannya dengan bahasa yang mudah dipahami.</p>
        </div>

        <div class="w-[1000px] h-full py-6 px-7 border-2 flex items-center justify-between border-gray-400 rounded-xl mt-5 backdrop-blur-lg">
            <h1 class=" text-[#1167B1] font-bold text-xl tracking-wide">Bagaimana Cara Bayar Cicilan?</h1>
            <img src="{{asset('images/plus.png')}}" alt="">
        </div>

        <div class="w-[1000px] h-full py-6 px-7 border-2 flex items-center justify-between border-gray-400 rounded-xl mt-5 backdrop-blur-lg">
            <h1 class=" text-[#1167B1] font-bold text-xl tracking-wide">Berapa Lama Proses Pencairan Dana?</h1>
            <img src="{{asset('images/plus.png')}}" alt="">
        </div>

        <div class="w-[1000px] h-full py-6 px-7 border-2 flex items-center justify-between border-gray-400 rounded-xl mt-5 backdrop-blur-lg">
            <h1 class=" text-[#1167B1] font-bold text-xl tracking-wide">Apa Keunggulan Pinjaman Berbasis Blockchain?</h1>
            <img src="{{asset('images/plus.png')}}" alt="">
        </div>

        <img src="{{asset('images/cirlcebg.png')}}" class="absolute left-0 top-80 -z-20" alt="">

    </section>

    {{-- Footer --}}
    <section class="relative flex flex-col mt-8 w-full h-full border rounded-t-[100px] bg-[#1167B1]">
        <x-landingpage.footer></x-landingpage.footer>
    </section>


</body>
</html>
