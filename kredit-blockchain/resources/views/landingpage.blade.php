<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Landing Page</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{asset('css/landingpage.css')}}">
    <script defer src="{{ asset('js/landingpage.js') }}"></script>
</head>

<body class="flex flex-col justify-center items-center m-0 p-0">

    {{-- Navbar and Hero --}}
    <section id="home">
        <div class="h-[850px] ">
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
    </section>

    {{-- Collaborated --}}
    <section class="flex flex-col items-center justify-center w-full h-[300px] px-[100px] bg-[#D0EFFF]" id="collaborated">
        <h1 class="text-[#2A9DF4] font-bold text-lg tracking-widest">COLLABORATED WITH</h1>
        <div class="overflow-hidden mt-10 w-full">
            <div class="marquee">
                <!-- Konten asli -->
                <div class="marquee-content inline-flex items-center justify-center gap-x-[130px] mr-[130px]">
                    <img src="images/bi_logo.png" alt="BI Logo" class="h-12">
                    <img src="images/bri_logo.png" alt="BRI Logo" class="h-12">
                    <img src="images/logo_BCA_Biru.png" alt="BCA Logo" class="h-12">
                    <img src="images/mandiri_logo.png" alt="Mandiri Logo" class="h-12">
                    <img src="images/ojk_logo.png" alt="OJK Logo" class="h-12">
                </div>
                <!-- Konten duplikat untuk loop mulus -->
                <div class="marquee-content inline-flex items-center justify-center gap-x-[130px]">
                    <img src="images/bi_logo.png" alt="BI Logo" class="h-12 mt-5">
                    <img src="images/bri_logo.png" alt="BRI Logo" class="h-12">
                    <img src="images/logo_BCA_Biru.png" alt="BCA Logo" class="h-12">
                    <img src="images/mandiri_logo.png" alt="Mandiri Logo" class="h-12">
                    <img src="images/ojk_logo.png" alt="OJK Logo" class="h-12">
                </div>
            </div>
        </div>
    </section>

    {{-- Kenapa Memilih Kami --}}
    <section class="flex flex-col items-center w-full h-full px-[100px] pt-[90px] relative" id="kenapa-memilih-kami">
        <h1 class="text-[#2A9DF4] font-semibold tracking-widest text-xl hidden-animated">PILIH CREDITBLOCK</h1>
        <h1 class="text-[#1167B1] font-bold tracking-widest text-4xl mt-2 hidden-animated">KENAPA MEMILIH KAMI?!</h1>

        <div class="grid grid-cols-2 gap-6 mt-10 items-center justify-center">

            <x-landingpage.grid-column class="group hidden-animated">
                <h1 class="font-bold text-2xl">PROSES PENGAJUAN CEPAT</h1>
                <div class="inline-flex mt-3 gap-x-[50px]">
                    <img src="{{asset('images/01.png')}}" alt="" class="opacity-0 mt-[108px] group-hover:opacity-100 duration-500 transition-opacity">
                    <p class="mt-10 text-gray-600 group-hover:text-black">Isi form super singkat, langsung dapat dana! Tidak perlu antri atau ribet dokumen – cair lebih cepat dari kopi pagimu.</p>
                </div>
            </x-landingpage.grid-column>

            <x-landingpage.grid-column class="group hidden-animated">
                <h1 class="font-bold text-2xl">TRANSPARANSI BLOCKCHAIN</h1>
                <div class="inline-flex mt-3 gap-x-[50px]">
                    <img src="{{asset('images/02.png')}}" alt="" class="mt-[108px] opacity-0 group-hover:opacity-100 duration-500 transition-opacity">
                    <p class="mt-10 text-gray-600 group-hover:text-black">Setiap transaksi tercatat abadi di blockchain – tidak bisa dimanipulasi atau "kecurangan administrasi".</p>
                </div>
            </x-landingpage.grid-column>

            <x-landingpage.grid-column class="group hidden-animated">
                <h1 class="font-bold text-2xl flex justify-end">DASHBOARD PRIBADI</h1>
                <div class="inline-flex mt-3 gap-x-[50px]">
                    <p class="mt-10 text-gray-600 group-hover:text-black">Pantau pinjaman, cicilan, dan riwayat pembayaran semudah cek media sosial – semua rapi dalam satu layar.</p>
                    <img src="{{asset('images/03.png')}}" alt="" class="mt-[108px] opacity-0 group-hover:opacity-100 duration-500 transition-opacity">
                </div>
            </x-landingpage.grid-column>

            <x-landingpage.grid-column class="group hidden-animated">
                <h1 class="font-bold text-2xl flex justify-end">NOTIFIKASI JATUH TEMPO</h1>
                <div class="inline-flex mt-3 gap-x-[50px]">
                    <p class="mt-10 text-gray-600 group-hover:text-black">Sistem kami akan ingatkan Anda sebelum jatuh tempo – seperti asisten pribadi yang selalu on time.</p>
                    <img src="{{asset('images/04.png')}}" alt="" class="mt-[108px] opacity-0 group-hover:opacity-100 duration-500 transition-opacity">
                </div>
            </x-landingpage.grid-column>


        </div>
        <div class="flex mt-[25px] flex-col w-[600px] px-8 py-5 h-[300px] rounded-3xl border-2 border-gray-300 bg-[#c7e7ff] hidden-animated transition ease-in-out hover:-translate-y-1 hover:shadow-xl group">
            <h1 class="font-bold text-2xl">KALKULATOR CICILAN</h1>
            <div class="inline-flex mt-3 gap-x-[50px]">
                <img src="{{asset('images/05.png')}}" alt="" class="mt-[108px] opacity-0 group-hover:opacity-100 duration-500 transition-opacity ">
                <p class="mt-10 text-gray-600 group-hover:text-black">Rencanakan pinjaman dengan percaya diri – tahu persis berapa yang harus dibayar sebelum mengajukan!</p>
            </div>
        </div>

        <img src="{{asset('images/bg-circle.png')}}" alt="" class="absolute left-0 mt-[100px] -z-10 bottom-0 w-[800px]">
        <div class="absolute right-0 w-[200px] h-[400px] rounded-l-full bg-[#94CEF9] -z-10">

        </div>
    </section>

    {{-- Langkah Mudah --}}
    <section class="flex flex-col items-center w-full h-full px-[100px] pt-[90px] relative mb-10" id="langkah-mudah">
        <h1 class="text-[#2A9DF4] font-semibold tracking-widest text-xl hidden-animated">LANGKAH MUDAH</h1>
        <h1 class="text-[#1167B1] font-bold text-5xl tracking-wide hidden-animated mt-2">Langkah Mudah Mendapatkan Pinjaman</h1>

        <div class="w-[1100px] px-10 py-10 h-full border border-gray-300 rounded-xl mt-10 backdrop-blur-md">

            <x-landingpage.easy-step class="hidden-animated">

                <h1 class="font-bold text-lg text-[#2A9DF4]">01.</h1>
                <div class="flex flex-col w-full h-full ml-10">
                    <h1 class="font-semibold text-xl">Daftar dengan E-mail dan Kata Sandi</h1>
                    <p class="mt-3 text-sm">
                        Dana cair lebih cepat dari kopi pagimu! Cukup masukkan email dan buat sandi sederhana - prosesnya hanya 30 detik saja. Kami langsung mengirimkan email verifikasi untuk memastikan keamanan akun Anda. Setelah klik link verifikasi, Anda langsung masuk ke dashboard pribadi yang siap digunakan. Lebih praktis dari membuat akun media sosial, dan yang pasti lebih menguntungkan!
                    </p>
                </div>

            </x-landingpage.easy-step>

            <div class="w-full border my-10"></div>

            <x-landingpage.easy-step class="hidden-animated">

                <h1 class="font-bold text-lg text-[#2A9DF4]">02.</h1>
                <div class="flex flex-col w-full h-full ml-10">
                    <h1 class="font-semibold text-xl">Ajukan Pinjaman dengan Form Sederhana</h1>
                    <p class="mt-3 text-sm">
                        Raih dana yang Anda butuhkan tanpa ribet! Formulir kami super sederhana - hanya butuh 3 informasi utama dengan desain slider yang mudah digunakan. Tentukan sendiri jumlah pinjaman dan jangka waktu yang nyaman untuk dompet Anda. Semua perhitungan langsung terlihat transparan di depan mata, tanpa biaya tersembunyi yang mengejutkan. Tinggal tekan 'Ajukan' dan biarkan sistem cerdas kami bekerja untuk kesuksesan finansial Anda!
                    </p>
                </div>

            </x-landingpage.easy-step>

            <div class="w-full border my-10"></div>

            <x-landingpage.easy-step class="hidden-animated">

                <h1 class="font-bold text-lg text-[#2A9DF4]">03.</h1>
                <div class="flex flex-col w-full h-full ml-10">
                    <h1 class="font-semibold text-xl">Unggah Dokumen Pendukung (KYC/Slip Gaji)</h1>
                    <p class="mt-3 text-sm">
                        Verifikasi kilat tanpa harus keluar rumah! Proses KYC kami cepat dan aman dengan teknologi enkripsi mutakhir - cukup foto KTP dan selfie sederhana. Untuk pinjaman lebih besar, tambahkan slip gaji atau bukti penghasilan dengan sekali unggah saja. Dokumen Anda kami jamin kerahasiaannya dan hanya digunakan untuk verifikasi. Tidak perlu antri di bank atau repot fotokopi dokumen fisik yang merepotkan!
                    </p>
                </div>

            </x-landingpage.easy-step>

            <div class="w-full border my-10"></div>

            <x-landingpage.easy-step class="hidden-animated">

                <h1 class="font-bold text-lg text-[#2A9DF4]">04.</h1>
                <div class="flex flex-col w-full h-full ml-10">
                    <h1 class="font-semibold text-xl">Pantau Status di Dashboard</h1>
                    <p class="mt-3 text-sm">
                        Kontrol penuh di genggaman tangan Anda! Dashboard canggih kami memberikan update real-time setiap tahap proses, seperti melacak paket online favorit Anda. Dapatkan notifikasi instan saat pinjaman disetujui dan dana siap cair. Semua informasi cicilan disajikan dalam grafik interaktif yang mudah dimengerti. Akses kapan saja, di mana saja - bahkan saat sedang bepergian sekalipun!
                    </p>
                </div>

            </x-landingpage.easy-step>

            <div class="w-full border my-10"></div>

            <x-landingpage.easy-step class="hidden-animated">

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
            <button class="inline-flex hidden-animated h-full items-center px-[150px] py-4 text-[20px] text-white font-bold shadow-xl rounded-full bg-blue-300 transition duration-300 ease-in-out hover:-translate-y-1  hover:bg-[#2A9DF4]">
                Pelajari Lebih Lanjut
                <img src="{{asset('images/arrow.png')}}" alt="" class="w-[15px] h-[15px] ml-3 ">
            </button>
        </a>

        <img src="{{asset('images/cirlcebg.png')}}" class="absolute left-0 top-200 -z-20" alt="">
    </section>

    {{-- Loan Calculator --}}
    <section class="flex flex-col items-center w-full h-full px-[100px] py-[60px] text-center relative" id="loan-calculator">
    <h1 class="text-[#2A9DF4] font-semibold tracking-widest text-lg hidden-animated">LOAN CALCULATOR</h1>
    <h1 class="text-[40px] w-[900px] tracking-wide font-bold text-[#1167B1] hidden-animated">Hitung Cicilanmu Sekarang & Temukan Cara Lebih Ringan untuk Membayar!</h1>

    <div class="flex flex-col items-center px-10 py-10 bg-white mt-10 rounded-xl border h-full border-gray-300 shadow-blue-300 shadow-xl">
        <x-landingpage.loan-calculator></x-landingpage.loan-calculator>
        <p class="text-center tracking-wider w-[500px] text-gray-500 hidden-animated mt-4">
            Anda dapat mensimulasikan cicilan yang akan dipinjam dengan tepat!
        </p>
    </div>

    <img src="{{ asset('images/blur2.png') }}" alt="" class="absolute right-0 top-200 -z-20">
</section>

    {{-- Apa Kata Pengguna --}}
    <section class="flex flex-col items-center w-full h-full px-[100px] py-[90px] text-center overflow-hidden relative" id="people">

        <h1 class="text-[#2A9DF4] font-semibold tracking-widest text-xl hidden-animated">DIPERCAYA DAN AMAN</h1>
        <h1 class="text-[#1167B1] font-bold text-5xl mt-2 tracking-wide hidden-animated">Apa Kata Pengguna Kami?</h1>

            <div class="marquee-2">

                <div class="marquee-content inline-flex mt-[50px] gap-x-[50px] mr-[50px]">

                    <x-landingpage.people></x-landingpage.people>

                </div>

                <div class="marquee-content inline-flex mt-[50px] gap-x-[50px]">

                    <x-landingpage.people></x-landingpage.people>

                </div>

            </div>

    </section>


    {{-- FAQ --}}
    <section class="relative flex flex-col items-center py-[90px] justify-center w-full h-full px-[100px]" id="faq">

        <div
            class="absolute w-full h-[400px] blur-[90px] bg-blue-100 top-50 -z-20">
        </div>

        <h1 class="text-[#2A9DF4] font-semibold tracking-widest text-xl hidden-animated">FAQ</h1>
        <h1 class="text-[#1167B1] font-bold text-5xl mt-2 tracking-wide hidden-animated">Frequently Asked Questions</h1>

        <div class="w-[1000px] py-6 px-7 border-2 border-gray-400 rounded-xl mt-10 hidden-animated accordion-section" id="accordion-section-1" data-expanded="false">
            <div class="header-container">
                <h1 class="text-[#1167B1] font-bold text-xl tracking-wide">Apa itu Wallet Blockchain ?</h1>
                <img src="images/plus.png" alt="Toggle Icon" class="cursor-pointer toggle-icon" width="24" height="24">
            </div>
            <div class="explanation">
                <p class="text-gray-500 mt-3">Wallet blockchain adalah dompet digital khusus yang digunakan untuk menyimpan dan mengelola aset kripto. Dalam konteks layanan kami, wallet ini berfungsi sebagai sarana untuk menerima dana pinjaman, melakukan pembayaran cicilan, serta memantau seluruh riwayat transaksi yang tercatat secara permanen di jaringan blockchain. Bagi pengguna baru yang belum familiar, kami menyediakan panduan lengkap mulai dari cara membuat wallet hingga tutorial penggunaannya dengan bahasa yang mudah dipahami.</p>
            </div>
        </div>

        <div class="w-[1000px] py-6 px-7 border-2 border-gray-400 rounded-xl mt-5 hidden-animated accordion-section" id="accordion-section-2" data-expanded="false">
            <div class="header-container">
                <h1 class="text-[#1167B1] font-bold text-xl tracking-wide">Bagaimana Cara Bayar Cicilan ?</h1>
                <img src="images/plus.png" alt="Toggle Icon" class="cursor-pointer toggle-icon" width="24" height="24">
            </div>
            <div class="explanation">
                <p class="text-gray-500 mt-3">Wallet blockchain adalah dompet digital khusus yang digunakan untuk menyimpan dan mengelola aset kripto. Dalam konteks layanan kami, wallet ini berfungsi sebagai sarana untuk menerima dana pinjaman, melakukan pembayaran cicilan, serta memantau seluruh riwayat transaksi yang tercatat secara permanen di jaringan blockchain. Bagi pengguna baru yang belum familiar, kami menyediakan panduan lengkap mulai dari cara membuat wallet hingga tutorial penggunaannya dengan bahasa yang mudah dipahami.</p>
            </div>
        </div>

        <div class="w-[1000px] py-6 px-7 border-2 border-gray-400 rounded-xl mt-5 hidden-animated accordion-section" id="accordion-section-3" data-expanded="false">
            <div class="header-container">
                <h1 class="text-[#1167B1] font-bold text-xl tracking-wide">Berapa Lama Proses Pencairan Dana ?</h1>
                <img src="images/plus.png" alt="Toggle Icon" class="cursor-pointer toggle-icon" width="24" height="24">
            </div>
            <div class="explanation">
                <p class="text-gray-500 mt-3">Wallet blockchain adalah dompet digital khusus yang digunakan untuk menyimpan dan mengelola aset kripto. Dalam konteks layanan kami, wallet ini berfungsi sebagai sarana untuk menerima dana pinjaman, melakukan pembayaran cicilan, serta memantau seluruh riwayat transaksi yang tercatat secara permanen di jaringan blockchain. Bagi pengguna baru yang belum familiar, kami menyediakan panduan lengkap mulai dari cara membuat wallet hingga tutorial penggunaannya dengan bahasa yang mudah dipahami.</p>
            </div>
        </div>

        <div class="w-[1000px] py-6 px-7 border-2 border-gray-400 rounded-xl mt-5 hidden-animated accordion-section" id="accordion-section-4" data-expanded="false">
            <div class="header-container">
                <h1 class="text-[#1167B1] font-bold text-xl tracking-wide">Apa Keunggulan Pinjaman Berbasis Blockchain ?</h1>
                <img src="images/plus.png" alt="Toggle Icon" class="cursor-pointer toggle-icon" width="24" height="24">
            </div>
            <div class="explanation">
                <p class="text-gray-500 mt-3">Wallet blockchain adalah dompet digital khusus yang digunakan untuk menyimpan dan mengelola aset kripto. Dalam konteks layanan kami, wallet ini berfungsi sebagai sarana untuk menerima dana pinjaman, melakukan pembayaran cicilan, serta memantau seluruh riwayat transaksi yang tercatat secara permanen di jaringan blockchain. Bagi pengguna baru yang belum familiar, kami menyediakan panduan lengkap mulai dari cara membuat wallet hingga tutorial penggunaannya dengan bahasa yang mudah dipahami.</p>
            </div>
        </div>

        <img src="{{asset('images/cirlcebg.png')}}" class="absolute left-0 top-80 -z-20" alt="">

    </section>

    {{-- Footer --}}
    <section class="relative flex flex-col mt-8 w-full h-full border rounded-t-[100px] bg-[#1167B1] hidden-animated">
        <x-landingpage.footer></x-landingpage.footer>
    </section>

</body>
</html>
