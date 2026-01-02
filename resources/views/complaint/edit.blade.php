<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Complaint C-' . $complaint->id) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">

                <form method="POST" action="{{ route('complaint.update', $complaint) }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <h3 class="text-2xl font-bold text-gray-900 border-b pb-3 mb-6">Complaint Details</h3>

                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 required-label">Subject (Brief Title)</label>
                        <input id="subject" name="subject" type="text" value="{{ old('subject', $complaint->subject) }}" required autofocus
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-3 focus:ring-green-500 focus:border-green-500 @error('subject') border-red-500 @enderror">
                        @error('subject') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="target_office_id" class="block text-sm font-medium text-gray-700 required-label">Target Office / Department</label>
                        <select id="target_office_id" name="target_office_id" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-3 focus:ring-green-500 focus:border-green-500 @error('target_office_id') border-red-500 @enderror">
                            <option value="">-- Select an Office --</option>
                            @foreach ($offices as $office)
                                <option value="{{ $office->id }}" {{ old('target_office_id', $complaint->target_office_id) == $office->id ? 'selected' : '' }}>
                                    {{ $office->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('target_office_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 required-label">Detailed Description of Complaint</label>
                        <textarea id="description" name="description" rows="6" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-3 focus:ring-green-500 focus:border-green-500 @error('description') border-red-500 @enderror">{{ old('description', $complaint->description) }}</textarea>
                        @error('description') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        @if ($complaint->file_path)
                            <p class="text-sm text-gray-500 mb-2">Current File: <a href="{{ \Storage::disk('public')->url($complaint->file_path) }}" target="_blank" class="text-blue-500 hover:underline">View Current File</a>. Uploading a new file will replace it.</p>
                        @endif
                        <label for="file_upload" class="block text-sm font-medium text-gray-700">Replace Supporting Document / Evidence (Optional)</label>
                        <input id="file_upload" name="file_upload" type="file"
                            class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-md cursor-pointer bg-gray-50 focus:outline-none @error('file_upload') border-red-500 @enderror">
                        <p class="mt-1 text-xs text-gray-500">Max 2MB. Allowed formats: JPG, PNG, PDF.</p>
                        @error('file_upload') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out">
                            Update Complaint
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
