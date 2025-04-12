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
<body class="flex justify-center items-center m-0 p-0 overflow-auto">

    <div class="container w-full h-full ">

        {{-- Navbar --}}
        <section class="flex justify-between items-center w-full h-[100px] px-[100px]">
            <x-landingpage.logoNavbar></x-landingpage.logoNavbar>
            <x-landingpage.nav-item></x-landingpage.nav-item>
            <div class="flex gap-x-3">
                <a href="">
                    <x-landingpage.auth-button>
                        <img src="{{asset('images/phone.png')}}" alt="">
                        <p class="text-white font-bold ml-2"> Login </p>
                    </x-landingpage.auth-button>
                </a>
                <a href="">
                    <x-landingpage.auth-button>
                        <img src="{{asset('images/phone.png')}}" alt="">
                        <p class="text-white font-bold ml-2">Sign Up </p>
                    </x-landingpage.auth-button>
                </a>
            </div>

        </section>

        <div class="w-full h-[1px] bg-[#c7e7ff]"></div>
        {{-- Navbar End --}}

        {{-- Hero --}}
        <section class="flex justify-center items-center w-full h-[684px]">
            <x-landingpage.hero></x-landingpage.hero>
        </section>
        {{-- Hero End --}}


        <img src="{{asset('images/bgBlur.png')}}" alt="" class="absolute left-0 top-60 -z-10">
        <img src="{{asset('images/bgNonBlur.png')}}" alt="" class="absolute right-0 top-60 -z-10">

        <section class="flex w-full h-[684px] px-[100px]">
            <h1>Lorem ipsum dolor sit amet consectetur adipisicing elit.</h1>
        </section>

    </div>
</body>
</html>
