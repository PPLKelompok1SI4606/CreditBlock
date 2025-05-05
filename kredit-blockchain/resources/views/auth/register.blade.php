<x-guest-layout>
    <h1 class="font-bold text-3xl text-center w-[500px] mb-10">Gabung dan Sambungkan Dompet Kredit bersama Kami 🥰</h1>

    <form id="registerForm" method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-auth.input-label for="name" :value="__('Name')" />
            <x-auth.text-input
                id="name"
                class="block mt-1 w-[400px]"
                type="text"
                name="name"
                :value="old('name')"
                required
                autofocus
                autocomplete="name"
            />
            <x-auth.input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-auth.input-label for="email" :value="__('Email')" />
            <x-auth.text-input
                id="email"
                class="block mt-1 w-full"
                type="email"
                name="email"
                :value="old('email')"
                required
                autocomplete="username"
            />
            <x-auth.input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-auth.input-label for="password" :value="__('Password')" />
            <x-auth.text-input
                id="password"
                class="block mt-1 w-full"
                type="password"
                name="password"
                required
                autocomplete="new-password"
            />
            <x-auth.input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-auth.input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-auth.text-input
                id="password_confirmation"
                class="block mt-1 w-full"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
            />
            <x-auth.input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <div class="flex mt-5 relative w-full">
            <div class="ml-auto">
                <button type="submit" class="inline-flex items-center px-[50px] py-4 bg-[#2A9DF4] border-transparent shadow-xl shadow-blue-200 rounded-full font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#0090FE] focus:bg-[#0090FE] active:bg-[#0090FE] focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-300 ease-in-out hover:-translate-y-1 hover:scale-110">
                    {{ __('Next') }}
                </button>
            </div>
        </div>

        <div class="w-full flex justify-center mt-[50px]">
            <h1>Sudah Punya Akun?
                <a href="{{ route('login') }}" class="text-blue-400">Mari Kesini</a>
            </h1>
        </div>
        <div class="inline-flex gap-x-4 justify-center w-full mt-[20px] items-center">
            <a href="{{ route('welcome') }}">
                <div class="py-2 px-4 border rounded-full {{ request()->routeIs('welcome') ? 'bg-blue-500 text-white' : 'hover:bg-blue-500 hover:text-white' }}">
                    1
                </div>
            </a>
            <a href="{{ route('register') }}">
                <div class="py-2 px-4 border rounded-full {{ request()->routeIs('register') ? 'bg-blue-500 text-white' : 'hover:bg-blue-500 hover:text-white' }}">
                    2
                </div>
            </a>
            <a href="#">
                <div class="py-2 px-4 border rounded-full {{ request()->routeIs('kyc') ? 'bg-blue-500 text-white' : 'hover:bg-blue-500 hover:text-white' }}">
                    3
                </div>
            </a>
        </div>
    </form>
</x-guest-layout>
