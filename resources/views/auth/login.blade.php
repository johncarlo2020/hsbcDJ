<x-guest-layout>
    <h1>LOGIN</h1>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Mobile Number')" />
            <x-text-input id="email" class="block w-full mt-1" type="tel" name="tel" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="devider">
            <span>OR</span>
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4" style="display: none">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block w-full mt-1"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="button">
                {{ __('LOGIN') }}
            </x-primary-button>
        </div>
    </form>
    <div class="bottom-text">
        <p>Don’t have account yet! Register <a class="" href="{{ route('register') }}">
            {{ __('REGISTER') }}
        </a></p>
    </div>
</x-guest-layout>
