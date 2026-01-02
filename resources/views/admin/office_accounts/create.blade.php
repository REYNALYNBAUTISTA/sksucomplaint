<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Onboard New Office') }}
            </h2>
            <a href="{{ route('admin.offices.index') }}" class="text-sm text-gray-500 hover:text-gray-900 underline">
                &larr; Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Form points to the 'store' route we defined --}}
            <form method="POST" action="{{ route('admin.office-accounts.store') }}" class="space-y-6">
                @csrf

                {{-- SECTION 1: OFFICE DETAILS --}}
                <div class="bg-white p-8 shadow-sm sm:rounded-lg border-t-4 border-indigo-500">
                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-indigo-700 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5"></path></svg>
                            Step 1: Office Information
                        </h3>
                        <p class="text-sm text-gray-500">Define the name of the new department or unit (e.g., "Registrar", "Finance").</p>
                    </div>

                    {{-- Office Name --}}
                    <div>
                        <x-input-label for="office_name" :value="__('Office Name')" />
                        <x-text-input id="office_name" class="block mt-1 w-full" type="text" name="office_name" :value="old('office_name')" required autofocus placeholder="e.g. Office of Student Affairs" />
                        <x-input-error :messages="$errors->get('office_name')" class="mt-2" />
                    </div>
                </div>

                {{-- SECTION 2: PERSONNEL ACCOUNT --}}
                <div class="bg-white p-8 shadow-sm sm:rounded-lg border-t-4 border-green-500">
                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-green-700 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Step 2: Personnel Account
                        </h3>
                        <p class="text-sm text-gray-500">Create the login credentials for the staff member managing this office.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Personnel Name --}}
                        <div class="md:col-span-2">
                            <x-input-label for="name" :value="__('Full Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required placeholder="e.g. Juan Dela Cruz" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        {{-- ID Number --}}
                        <div>
                            <x-input-label for="id_number" :value="__('Employee ID Number')" />
                            <x-text-input id="id_number" class="block mt-1 w-full" type="text" name="id_number" :value="old('id_number')" required placeholder="e.g. EMP-2023-001" />
                            <x-input-error :messages="$errors->get('id_number')" class="mt-2" />
                        </div>

                        {{-- Email --}}
                        <div>
                            <x-input-label for="email" :value="__('Email Address')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required placeholder="staff@sksu.edu.ph" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        {{-- Password --}}
                        <div>
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        {{-- Confirm Password --}}
                        <div>
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required placeholder="••••••••" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-end">
                    <a href="{{ route('admin.offices.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">Cancel</a>
                    <x-primary-button class="bg-indigo-600 hover:bg-indigo-700">
                        {{ __('Create Office & Account') }}
                    </x-primary-button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
