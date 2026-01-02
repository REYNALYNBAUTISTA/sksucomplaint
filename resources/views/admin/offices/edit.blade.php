<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Office: ') . $office->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('admin.offices.update', $office) }}" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- OFFICE DETAILS CARD --}}
                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <h3 class="text-lg font-bold mb-4 border-b pb-2 text-indigo-700">{{ __('Office Details') }}</h3>

                    {{-- Office Name --}}
                    <div>
                        <x-input-label for="office_name" :value="__('Office Name')" />
                        <x-text-input id="office_name" class="block mt-1 w-full" type="text" name="office_name" :value="old('office_name', $office->name)" required autofocus />
                        <x-input-error :messages="$errors->get('office_name')" class="mt-2" />
                    </div>


                </div>

                {{-- PERSONNEL DETAILS & REASSIGNMENT CARD --}}
                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <h3 class="text-lg font-bold mb-4 border-b pb-2 text-indigo-700">
                        {{ $currentPersonnel ? __('Assigned Personnel Details') : __('Assign Personnel') }}
                    </h3>

                    @if($currentPersonnel)
                        {{-- Personnel Name --}}
                        <div>
                            <x-input-label for="personnel_name" :value="__('Personnel Full Name')" />
                            <x-text-input id="personnel_name" class="block mt-1 w-full" type="text" name="personnel_name" :value="old('personnel_name', $currentPersonnel->name)" required />
                            <x-input-error :messages="$errors->get('personnel_name')" class="mt-2" />
                        </div>

                        {{-- ID Number --}}
                        <div class="mt-4">
                            <x-input-label for="id_number" :value="__('ID Number')" />
                            <x-text-input id="id_number" class="block mt-1 w-full" type="text" name="id_number" :value="old('id_number', $currentPersonnel->id_number)" required />
                            <x-input-error :messages="$errors->get('id_number')" class="mt-2" />
                        </div>

                        {{-- Email --}}
                        <div class="mt-4">
                            <x-input-label for="email" :value="__('Email (Login)')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $currentPersonnel->email)" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        {{-- Password (Optional) --}}
                        <div class="mt-4">
                            <x-input-label for="password" :value="__('New Password (Leave blank to keep current)')" />
                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        {{-- Password Confirmation (Optional) --}}
                        <div class="mt-4">
                            <x-input-label for="password_confirmation" :value="__('Confirm New Password')" />
                            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>


                    @endif



                </div>


                <div class="flex items-center justify-end mt-4">
                    <a href="{{ route('admin.offices.index') }}" class="text-sm text-gray-600 underline mr-4">Cancel</a>
                    <x-primary-button>
                        {{ __('Update Office & Personnel') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
