<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Route Complaint C-' . $complaint->id) }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:text-indigo-800 flex items-center mb-4">
                &larr; Back to Dashboard Queue
            </a>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="lg:col-span-2 bg-white shadow-xl rounded-lg overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 border-b pb-2">Complaint Details</h3>

                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div class="font-semibold text-gray-700">Student:</div>
                            <div class="text-gray-900">{{ $complaint->user->name }} ({{ $complaint->user->id_number }})</div>

                            <div class="font-semibold text-gray-700">Date Filed:</div>
                            <div class="text-gray-900">{{ $complaint->created_at->format('M d, Y h:i A') }}</div>

                            <div class="font-semibold text-gray-700">Status:</div>
                            <div class="text-yellow-700 font-medium">Pending Routing</div>

                            <div class="font-semibold text-gray-700">Student's Target Office:</div>
                            <div class="text-gray-900">{{ $complaint->targetOffice->name ?? 'N/A' }}</div>
                        </div>

                        <h4 class="text-xl font-bold text-gray-900 mt-6 mb-3 border-b pb-2">Subject: {{ $complaint->subject }}</h4>

                        <p class="text-gray-700 whitespace-pre-wrap">{{ $complaint->description }}</p>

                        @if ($complaint->file_path)
                            <div class="mt-6 pt-4 border-t border-gray-200">
                                <a href="{{ \Storage::disk('public')->url($complaint->file_path) }}" target="_blank" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                                    <svg class="w-5 h-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13l-3 3m0 0l-3-3m3 3V8m0 16a12 12 0 100-24 12 12 0 000 24z"/></svg>
                                    Download Supporting Document
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="lg:col-span-1 bg-gray-50 p-6 shadow-xl rounded-lg h-fit sticky top-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Admin Routing Decision</h3>

                    <form method="POST" action="{{ route('admin.complaint.route.process', $complaint) }}" class="space-y-4">
                        @csrf

                        <div>
                            <label for="assigned_office_id" class="block text-sm font-medium text-gray-700">Assign to Office</label>
                            <select id="assigned_office_id" name="assigned_office_id" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2.5 focus:ring-indigo-500 focus:border-indigo-500 @error('assigned_office_id') border-red-500 @enderror">
                                <option value="">-- Select Office --</option>
                                @foreach ($offices as $office)
                                    <option value="{{ $office->id }}" {{ old('assigned_office_id', $complaint->target_office_id) == $office->id ? 'selected' : '' }}>
                                        {{ $office->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('assigned_office_id')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="admin_remarks" class="block text-sm font-medium text-gray-700">Admin Notes for Office (Optional)</label>
                            <textarea id="admin_remarks" name="admin_remarks" rows="3"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2.5 focus:ring-indigo-500 focus:border-indigo-500 @error('admin_remarks') border-red-500 @enderror">{{ old('admin_remarks') }}</textarea>
                            @error('admin_remarks')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full inline-flex justify-center py-3 px-4 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out">
                                Route Complaint & Move to Office Queue
                            </button>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
