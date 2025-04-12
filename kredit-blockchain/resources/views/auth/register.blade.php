<x-guest-layout>

    <h1 class="font-bold text-3xl text-center w-[400px] mb-10">Join & Connect Secure Wallet for Credit</h1>

    <form method="POST" action="{{ route('register') }}">
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

        <!-- Remember Me and Button Login -->
        <div class="flex mt-7 relative w-full">
            <label for="remember_me" class="inline-flex items-center">
                <input
                    type="checkbox"
                    class="rounded p-[10px] border-gray-300 text-blue-400 shadow-sm focus:ring-0 focus:ring-offset-0"
                    name="remember"
                >
                <span class="ms-2 text-[11px] text-gray-400">{{ __('I accept the terms & Conditions') }}</span>
            </label>

            <div class="ml-auto">
                <x-auth.primary-button>
                    {{ __('Sign Up') }}
                </x-auth.primary-button>
            </div>

        </div>

        <div class="w-full flex justify-center mt-[70px]">
            <h1>Own an Account?
                <button class="transition duration-300 ease-in-out hover:-translate-y-1 hover:translate-x-1 hover:text-[#0090FE] hover:scale-110">
                    <a href={{ route('login') }} class="text-blue-400">Jump Right In</a>
                </button>
            </h1>
        </div>
    </form>
</x-guest-layout>
