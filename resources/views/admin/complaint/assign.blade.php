<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Route Complaint #') . $complaint->id }}
            </h2>
            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                Current Status: Pending Routing
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- COMPLAINT DETAILS CARD --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold text-gray-700 border-b pb-2 mb-4">Complaint Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <span class="block text-sm font-medium text-gray-500">Filed By</span>
                            <span class="text-gray-900">{{ $complaint->user->name }}
                                ({{ $complaint->user->id_number }})</span>
                        </div>
                        <div>
                            <span class="block text-sm font-medium text-gray-500">Date Filed</span>
                            <span class="text-gray-900">{{ $complaint->created_at->format('M d, Y h:i A') }}</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <span class="block text-sm font-medium text-gray-500">Subject</span>
                        <span class="text-lg font-semibold text-gray-900">{{ $complaint->subject }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500 mb-1">Description</span>
                        <div class="bg-gray-50 p-4 rounded-md border border-gray-200 text-gray-700">
                            {{ $complaint->description }}
                        </div>
                    </div>

                    @if ($complaint->file_path)
                        <div class="mt-4">
                            <a href="{{ Storage::url($complaint->file_path) }}" target="_blank"
                                class="text-indigo-600 hover:text-indigo-900 underline text-sm">
                                View Attached Evidence
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- ROUTING FORM CARD --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-indigo-500">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold text-indigo-700 border-b pb-2 mb-4">Routing Action</h3>

                    <form method="POST" action="{{ route('admin.complaints.assign', $complaint) }}">
                        @csrf

                        {{-- Office Selection Dropdown --}}
                        <select id="assigned_office_id" name="assigned_office_id"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            required>
                            <option value="" disabled>-- Choose an Office --</option>

                            @foreach ($offices as $office)
                                <option value="{{ $office->id }}" {{-- Pre-select if this office matches the student's target --}}
                                    {{ $complaint->target_office_id == $office->id ? 'selected' : '' }}>
                                    {{ $office->name }}
                                    @if ($complaint->target_office_id == $office->id)
                                        (Student's Suggestion)
                                    @endif
                                </option>
                            @endforeach
                        </select>

                        {{-- Admin Remarks (Optional) --}}
                        <div class="mb-4">
                            <x-input-label for="admin_remarks" :value="__('Admin Remarks / Instructions (Optional)')" />
                            <textarea id="admin_remarks" name="admin_remarks" rows="3"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                placeholder="Add any specific instructions for the office personnel..."></textarea>
                            <x-input-error :messages="$errors->get('admin_remarks')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.dashboard') }}"
                                class="text-sm text-gray-600 underline mr-4">Cancel</a>

                            <x-primary-button>
                                {{ __('Route Complaint') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
