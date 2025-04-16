<x-guest-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('status'))
    <div>Session Status: {{ session('status') }}</div>
    <script>
        console.log('Session status: {{ session('status') }}');
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: 'Sukses!',
                text: '{{ session('status') }}',
                confirmButtonText: 'OK',
                timer: 3000,
                timerProgressBar: true,
            }).then((result) => {
                // Redirect ke dashboard setelah alert ditutup
                window.location.href = '{{ route('admin.dashboard') }}';
            });
        });
        </script>
    @endif

<!-- Session Status -->
<x-auth.auth-session-status class="mb-4" :status="session('status')" />

    <h1 class="font-bold text-3xl text-center w-[500px]">Selamat Datang Admin di Aplikasi CreditBlock 🗿</h1>

    <div class="mt-8">
        <a href="{{route('login')}}">
            <x-auth.login-option>
                <div class="text-2xl">🧑🏻‍💼</div>
                <h1 class="text-gray-600 ml-2">Login sebagai Pengguna</h1>
            </x-auth.login-option>
        </a>
    </div>

    <form method="POST" action="{{ route('admin.login') }}">
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
        <div class="flex mt-10 relative w-full mb-[80px]">

            <div class="ml-auto">
                <x-auth.primary-button>
                    {{ __('Masuk') }}
                </x-auth.primary-button>
            </div>

        </div>
    </form>
</x-guest-layout>
