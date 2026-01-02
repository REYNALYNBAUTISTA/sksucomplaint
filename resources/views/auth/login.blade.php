<x-guest-layout>

    {{-- ============================== --}}
    {{-- 1. BRANDING HEADER             --}}
    {{-- ============================== --}}
    <div class="mb-8 text-center">
        {{-- Logo --}}
        <div class="flex justify-center mb-4">
            {{-- Ensure you have sksu_logo.png in public/images/ --}}
            <img src="{{ asset('images/sksu.png') }}"
                 alt="SKSU Logo"
                 class="h-24 w-24 object-contain hover:scale-105 transition-transform duration-300 drop-shadow-sm">
        </div>

        {{-- System Name --}}
        <h1 class="text-3xl font-extrabold text-green-900 tracking-tight font-serif">SKSU</h1>
        <p class="text-xs font-bold text-gray-500 uppercase tracking-[0.2em] mt-1 leading-relaxed">
            Student Complaints &<br>Assistance Desk
        </p>

        <div class="mt-6 relative">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t border-gray-200"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-gray-500 font-medium">Sign in to your account</span>
            </div>
        </div>
    </div>

    {{-- ============================== --}}
    {{-- 2. LOGIN FORM                  --}}
    {{-- ============================== --}}
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-bold" />
            <div class="relative mt-1 rounded-md shadow-sm">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <x-text-input id="email" class="block w-full pl-10 border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md"
                              type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                              placeholder="student@sksu.edu.ph" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <div class="flex justify-between items-center">
                <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-bold" />
                @if (Route::has('password.request'))
                    <a class="text-xs text-green-600 hover:text-green-800 font-semibold" href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <div class="relative mt-1 rounded-md shadow-sm">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <x-text-input id="password" class="block w-full pl-10 border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md"
                                type="password"
                                name="password"
                                required autocomplete="current-password"
                                placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block">
            <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500 cursor-pointer" name="remember">
                <span class="ms-2 text-sm text-gray-600 group-hover:text-gray-900">{{ __('Keep me logged in') }}</span>
            </label>
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full justify-center py-3 bg-green-700 hover:bg-green-800 active:bg-green-900 focus:ring-green-500 text-base font-bold tracking-wide">
                {{ __('Secure Login') }}
            </x-primary-button>
        </div>

        <div class="text-center mt-6">
            <p class="text-sm text-gray-600">
                Don't have an account yet?
                <a href="{{ route('register') }}" class="font-bold text-green-700 hover:text-green-900 hover:underline">
                    Create Student Account
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
