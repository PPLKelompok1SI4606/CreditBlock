<x-guest-layout>

    <h1 class="font-bold text-3xl text-center w-[400px]">Selamat Datang di Website CreditBlock 😎</h1>

    <div class="mt-8">
        <a href="/clear-session">
            <x-auth.login-option>
                <div class="text-2xl">🧑🏻‍💻</div>
                <h1 class="text-gray-600 ml-2">Login sebagai Admin</h1>
            </x-auth.login-option>
        </a>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mt-[50px]">
            <x-auth.input-label for="email" :value="__('Email')" />
            <x-auth.text-input
                id="email"
                class="block mt-1 w-[400px]"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
                autocomplete="username"
            />
            <x-auth.input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-10">
            <x-auth.input-label for="password" :value="__('Password')" />
            <x-auth.text-input
                id="password"
                class="block mt-1 w-full"
                type="password"
                name="password"
                required
                autocomplete="current-password"
            />
            <x-auth.input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me and Button Login -->
        <div class="flex mt-7 relative w-full">
            <label for="remember_me" class="inline-flex items-center">
                <input
                    id="remember_me"
                    type="checkbox"
                    class="rounded p-[10px] border-gray-300 text-blue-400 shadow-sm focus:ring-0 focus:ring-offset-0"
                    name="remember"
                >
                <span class="ms-2 text-sm text-gray-600">{{ __('Ingat Saya 😋') }}</span>
            </label>

            <div class="ml-auto">
                <x-auth.primary-button>
                    {{ __('Masuk') }}
                </x-auth.primary-button>
            </div>

        </div>

        <div class="w-full flex justify-center mt-[90px]">
            <h1>Belum Punya Akun?
                <button class="transition duration-300 ease-in-out hover:-translate-y-1 hover:translate-x-1 hover:text-[#0090FE] hover:scale-110">
                    <a href={{ route('welcome') }} class="text-blue-400">Daftar Disini</a>
                </button>
            </h1>
        </div>
    </form>
</x-guest-layout>
