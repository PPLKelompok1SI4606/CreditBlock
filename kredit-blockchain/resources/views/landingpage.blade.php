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
<body class="flex justify-center items-center m-0 p-0">

    <div>
        {{-- Navbar --}}
        <section class="flex items-center justify-between w-full h-[100px]">
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

        <section class="flex w-full h-[684px] px-[100px]">
            <h1>Lorem ipsum dolor sit amet consectetur adipisicing elit.</h1>
        </section>

    </div>

</body>
</html>
