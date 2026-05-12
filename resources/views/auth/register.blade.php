<x-guest-layout>
    <div class="flex flex-col items-center mb-4">
        <img src="{{ asset('logowogo2.png') }}" alt="Logo" class="w-24 h-auto mb-2">
        <h2 class="text-white text-xl font-bold tracking-widest">JOIN THE SURPLUS!</h2>
    </div>

    <form method="POST" action="{{ route('register') }}" class="w-full max-w-sm">
        @csrf

        <div>
            <x-text-input id="name" class="block mt-1 w-full bg-white/90 border-none" type="text" name="name" :value="old('name')" required autofocus placeholder="Username" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-300" />
        </div>

        <div class="mt-4">
            <x-text-input id="email" class="block mt-1 w-full bg-white/90 border-none" type="email" name="email" :value="old('email')" required placeholder="Email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-300" />
        </div>

        <div class="mt-4">
            <x-text-input id="password" class="block mt-1 w-full bg-white/90 border-none" type="password" name="password" required autocomplete="new-password" placeholder="Password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-300" />
        </div>

        <div class="mt-4">
            <x-text-input id="password_confirmation" class="block mt-1 w-full bg-white/90 border-none" type="password" name="password_confirmation" required placeholder="Confirm Password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-300" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="text-sm text-green-400 hover:text-green-300 font-bold underline" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="bg-gray-800 hover:bg-gray-700 text-white border-2 border-white px-6 py-2">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>