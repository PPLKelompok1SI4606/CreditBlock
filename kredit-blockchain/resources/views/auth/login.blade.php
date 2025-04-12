<x-guest-layout>
    <!-- Session Status -->
    <x-auth.auth-session-status class="mb-4" :status="session('status')" />

    <h1 class="font-bold text-3xl text-center w-[400px]">Welcome back to the CreditBlock Application</h1>

    <x-auth.login-option></x-auth.login-option>

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
                    class="rounded p-[10px] border-gray-300 text-blue-400 shadow-sm focus:ring-blue-300"
                    name="remember"
                >
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>

            <div class="ml-auto">
                <x-auth.primary-button>
                    {{ __('Log in') }}
                </x-auth.primary-button>
            </div>

        </div>

        <div class="w-full flex justify-center mt-[90px]">
            <h1>No Account yet? <a href={{ route('register') }} class="text-blue-400">Sign Up</a></h1>
        </div>
    </form>
</x-guest-layout>
