<x-guest-layout>

    {{-- ============================== --}}
    {{-- 1. BRANDING HEADER             --}}
    {{-- ============================== --}}
    <div class="mb-8 text-center">
        {{-- Logo --}}
        <div class="flex justify-center mb-4">
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
                <span class="px-2 bg-white text-gray-500 font-medium">Create your account</span>
            </div>
        </div>
    </div>

    {{-- ============================== --}}
    {{-- 2. REGISTRATION FORM           --}}
    {{-- ============================== --}}
    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Full Name')" class="text-gray-700 font-bold" />
            <div class="relative mt-1">
                <x-text-input id="name" class="block w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md"
                              type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                              placeholder="Juan Dela Cruz" />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="id_number" :value="__('ID Number')" class="text-gray-700 font-bold" />
            <div class="relative mt-1">
                <x-text-input id="id_number" class="block w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md"
                              type="text" name="id_number" :value="old('id_number')" required
                              placeholder="2023-XXXXX" />
            </div>
            <x-input-error :messages="$errors->get('id_number')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email Address')" class="text-gray-700 font-bold" />
            <div class="relative mt-1">
                <x-text-input id="email" class="block w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md"
                              type="email" name="email" :value="old('email')" required autocomplete="username"
                              placeholder="student@sksu.edu.ph" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-bold" />
            <div class="relative mt-1">
                <x-text-input id="password" class="block w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md"
                              type="password" name="password" required autocomplete="new-password"
                              placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-700 font-bold" />
            <div class="relative mt-1">
                <x-text-input id="password_confirmation" class="block w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md"
                              type="password" name="password_confirmation" required autocomplete="new-password"
                              placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full justify-center py-3 bg-green-700 hover:bg-green-800 active:bg-green-900 focus:ring-green-500 text-base font-bold tracking-wide">
                {{ __('Register Account') }}
            </x-primary-button>
        </div>

        <div class="text-center mt-6">
            <p class="text-sm text-gray-600">
                Already have an account?
                <a href="{{ route('login') }}" class="font-bold text-green-700 hover:text-green-900 hover:underline">
                    Log in here
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
