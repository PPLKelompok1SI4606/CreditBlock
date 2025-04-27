<x-guest-layout>

    <img src="{{asset('images/welcome1.png')}}" alt="" class="absolute right-0 top-0 -z-10">
    <div class="text-3xl font-bold"> Selamat Datang Di</div>
    <img src="{{asset('images/logoCB.png')}}" alt="" class="mt-4 w-[400px]">
    <a href="{{route('register')}}">
        <x-auth.primary-button class="mt-10">
            Ayo Mulai !
        </x-auth.primary-button>
    </a>
    <img src="{{asset('images/welcome2.png')}}" alt="" class="absolute left-0 bottom-0 -z-10">
</x-guest-layout>

