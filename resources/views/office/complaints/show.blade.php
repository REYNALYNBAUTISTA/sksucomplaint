<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Process Complaint #') . $complaint->id }}
            </h2>
            <a href="{{ route('office.dashboard') }}" class="text-sm text-gray-500 hover:text-gray-900 underline">
                &larr; Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- ========================================== --}}
                {{-- LEFT SIDEBAR: META DATA (Student & Admin)  --}}
                {{-- ========================================== --}}
                <div class="space-y-6">

                    {{-- Student Profile Card --}}
                    <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                        <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Filed By</h3>
                        </div>
                        <div class="p-6 flex items-center">
                            <div
                                class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xl mr-4">
                                {{ substr($complaint->user->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-lg font-bold text-gray-900">{{ $complaint->user->name }}</p>
                                <p class="text-sm text-gray-500">{{ $complaint->user->id_number }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $complaint->user->email }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Admin Instructions Card --}}
                    <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden border-l-4 border-yellow-400">
                        <div
                            class="px-6 py-4 bg-yellow-50 border-b border-yellow-100 flex justify-between items-center">
                            <h3 class="text-xs font-bold text-yellow-700 uppercase tracking-wider">Admin Remarks</h3>
                            <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="p-6">
                            <p class="text-sm text-gray-700 italic">
                                "{{ $complaint->admin_remarks ?? 'No specific instructions provided.' }}"
                            </p>
                            <div class="mt-4 pt-4 border-t border-gray-100 text-xs text-gray-400">
                                Routed on: {{ $complaint->updated_at->format('M d, Y, h:i A') }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ========================================== --}}
                {{-- RIGHT CONTENT: DETAILS & ACTION FORM       --}}
                {{-- ========================================== --}}
                <div class="lg:col-span-2 space-y-8">

                    {{-- Complaint Details Card --}}
                    <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                        <div class="p-8">
                            <span
                                class="inline-block px-3 py-1 mb-4 text-xs font-semibold tracking-wider text-indigo-800 uppercase bg-indigo-100 rounded-full">
                                Subject
                            </span>
                            <h1 class="text-3xl font-bold text-gray-900 mb-6">{{ $complaint->subject }}</h1>

                            <div class="mb-6">
                                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Description
                                </h4>
                                <div
                                    class="bg-gray-50 p-6 rounded-lg border border-gray-100 text-gray-800 leading-relaxed whitespace-pre-wrap">
                                    {{ trim($complaint->description) }}
                                </div>
                            </div>

                            @if ($complaint->file_path)
                                <div class="flex items-center p-4 bg-blue-50 rounded-lg border border-blue-100">
                                    <svg class="w-6 h-6 text-blue-500 mr-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                                        </path>
                                    </svg>
                                    <div class="flex-1">
                                        <p class="text-sm font-bold text-blue-900">Student Evidence Attached</p>
                                        <a href="{{ Storage::url($complaint->file_path) }}" target="_blank"
                                            class="text-xs text-blue-600 hover:text-blue-800 hover:underline">
                                            View / Download File
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- ⚡ ACTION AREA ⚡ --}}
                    <div class="bg-white shadow-lg sm:rounded-lg overflow-hidden border border-gray-200">
                        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-gray-800">Office Action</h3>
                            @if ($complaint->current_status_id == 2)
                                <span class="px-2 py-1 text-xs font-bold text-yellow-700 bg-yellow-100 rounded">Pending
                                    Action</span>
                            @else
                                <span
                                    class="px-2 py-1 text-xs font-bold text-green-700 bg-green-100 rounded">Processed</span>
                            @endif
                        </div>

                        <div class="p-6">
                            @if ($complaint->current_status_id == 2)
                                {{-- === EDITABLE FORM === --}}
                                <form action="{{ route('office.complaint.process', $complaint) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="grid grid-cols-1 gap-6">
                                        {{-- Decision Dropdown --}}
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Final
                                                Decision</label>
                                            <select name="status"
                                                class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                <option value="resolved">✅ Mark as Resolved / Processed</option>
                                                <option value="rejected">❌ Reject Complaint</option>
                                            </select>
                                        </div>

                                        {{-- Remarks Textarea --}}
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Resolution
                                                Details / Remarks</label>
                                            <textarea name="office_remarks" rows="5"
                                                class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                placeholder="Please provide details about the action taken..." required></textarea>
                                        </div>

                                        {{-- File Upload Field with Dynamic Filename --}}
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Attach Official
                                                Document (Optional)</label>

                                            {{-- 1. Initialize Alpine Data --}}
                                            {{-- Added 'items-center' to keep things centered vertically when the icon size changes --}}
                                            <div x-data="{ fileName: null }"
                                                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:bg-gray-50 transition items-center">
                                                <div class="space-y-1 text-center w-full"> {{-- Added w-full here --}}

                                                    {{-- Default Upload Icon (Gray, Large) --}}
                                                    <svg x-show="!fileName" class="mx-auto h-8 w-8 text-gray-400"
                                                        stroke="currentColor" fill="none" viewBox="0 0 48 48"
                                                        aria-hidden="true">
                                                        <path
                                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                    </svg>

                                                    {{-- ✅ FIXED: Selected Icon (Green, Small Checkmark) --}}
                                                    {{-- Changed from 'h-12 w-12 text-indigo-500' to 'h-8 w-8 text-green-500' --}}
                                                    <svg x-show="fileName" class="mx-auto h-8 w-8 text-green-500 mb-2"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>

                                                    <div class="flex text-sm text-gray-600 justify-center">
                                                        <label for="office_file"
                                                            class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">

                                                            {{-- 2. Update Text Dynamically --}}
                                                            <span
                                                                x-text="fileName ? 'Change File' : 'Upload a file'">Upload
                                                                a file</span>

                                                            {{-- 3. Capture File Name on Change --}}
                                                            <input id="office_file" name="office_file" type="file"
                                                                class="sr-only"
                                                                @change="fileName = $event.target.files[0].name">
                                                        </label>

                                                        <p class="pl-1" x-show="!fileName">or drag and drop</p>
                                                    </div>

                                                    {{-- 4. Show Selected Filename --}}
                                                    <p class="text-xs text-gray-500" x-show="!fileName">PDF, PNG, JPG
                                                        up to 5MB</p>
                                                    {{-- Added break-all to ensure long filenames don't overflow --}}
                                                    <p class="text-sm font-bold text-gray-900 mt-2 break-all"
                                                        x-show="fileName" x-text="fileName"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-8 flex justify-end items-center space-x-3">
                                        <a href="{{ route('office.dashboard') }}"
                                            class="px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-gray-700 hover:bg-gray-50">
                                            Cancel
                                        </a>
                                        <button type="submit"
                                            class="px-6 py-2 bg-green-600 border border-transparent rounded-md font-bold text-white hover:bg-green-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                            Submit Resolution
                                        </button>
                                    </div>
                                </form>
                            @else
                                {{-- === READ ONLY VIEW (PROCESSED) === --}}

                                {{-- Determine Colors based on Final Decision --}}
                                @php
                                    $isRejected = $complaint->final_decision === 'rejected';
                                    $theme = $isRejected ? 'red' : 'green'; // Use 'red' or 'green' classes
                                @endphp

                                <div class="bg-{{ $theme }}-50 rounded-lg border border-{{ $theme }}-200 p-6">

                                    {{-- Header with Icon --}}
                                    <div class="flex items-center mb-6 border-b border-{{ $theme }}-200 pb-4">
                                        <div class="h-10 w-10 rounded-full bg-{{ $theme }}-200 flex items-center justify-center text-{{ $theme }}-700 mr-4">
                                            @if($isRejected)
                                                {{-- X Icon for Rejected --}}
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            @else
                                                {{-- Check Icon for Resolved --}}
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            @endif
                                        </div>
                                        <div>
                                            <h4 class="text-lg font-bold text-{{ $theme }}-900">Action Complete</h4>
                                            <p class="text-xs text-{{ $theme }}-700">
                                                Processed on {{ $complaint->action_taken_at ? \Carbon\Carbon::parse($complaint->action_taken_at)->format('F j, Y, g:i a') : 'N/A' }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="space-y-5">

                                        {{-- ✅ Final Decision Display --}}
                                        <div>
                                            <span class="block text-xs font-bold text-{{ $theme }}-800 uppercase tracking-wide mb-1">
                                                Final Decision
                                            </span>
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-{{ $theme }}-100 text-{{ $theme }}-800 uppercase border border-{{ $theme }}-200">
                                                @if($isRejected)
                                                    ❌ {{ $complaint->final_decision }}
                                                @else
                                                    ✅ {{ $complaint->final_decision }}
                                                @endif
                                            </span>
                                        </div>

                                        {{-- Remarks --}}
                                        <div>
                                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Office Remarks:</p>
                                            <div class="bg-white p-3 rounded border border-{{ $theme }}-200 text-gray-800 text-sm">
                                                {{ $complaint->office_remarks }}
                                            </div>
                                        </div>

                                        {{-- File Attachment --}}
                                        @if ($complaint->office_file_path)
                                            <div>
                                                <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Attachment:</p>
                                                <div class="inline-flex items-center px-4 py-2 bg-white border border-{{ $theme }}-300 rounded-md shadow-sm">
                                                    <svg class="w-5 h-5 text-{{ $theme }}-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                    <a href="{{ Storage::url($complaint->office_file_path) }}" target="_blank" class="text-sm font-bold text-{{ $theme }}-700 hover:underline">
                                                        View Official Response File
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="mt-6 text-right">
                                        <a href="{{ route('office.dashboard') }}" class="text-indigo-600 font-bold hover:text-indigo-800 transition">Return to Dashboard &rarr;</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
