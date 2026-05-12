<x-guest-layout>
    <div class="flex flex-col items-center mb-4">
        <img src="{{ asset('logowogo2.png') }}" alt="Logo" class="w-32 h-auto mb-2">
        <h2 class="text-white text-2xl font-bold tracking-widest shadow-sm">PROBLEM SOLVER SURPLUS!</h2>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="w-full max-w-sm">
        @csrf

        <div>
            <x-text-input id="email" class="block mt-1 w-full bg-white/90 border-none" type="email" name="email" :value="old('email')" required autofocus placeholder="Email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-300" />
        </div>

        <div class="mt-4">
            <x-text-input id="password" class="block mt-1 w-full bg-white/90 border-none" type="password" name="password" required autocomplete="current-password" placeholder="Password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-300" />
        </div>

        <div class="flex items-center justify-between mt-6">
            @if (Route::has('register'))
                <a class="text-sm text-green-400 hover:text-green-300 font-bold underline" href="{{ route('register') }}">
                    {{ __('New here? Create an account') }}
                </a>
            @endif

            <x-primary-button class="bg-gray-800 hover:bg-gray-700 text-white border-2 border-white px-6 py-2">
                {{ __('Login') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>