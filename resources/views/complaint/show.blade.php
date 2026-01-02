<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between md:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Complaint Details') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Viewing Record #{{ $complaint->id }}</p>
            </div>
            <a href="{{ route('dashboard') }}"
                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                &larr; Return to List
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- ========================================== --}}
                {{-- LEFT COLUMN: MAIN CONTENT (2/3 Width)      --}}
                {{-- ========================================== --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- 1. RESOLUTION CARD (Only if Processed) --}}
                    @if ($complaint->current_status_id >= 4)
                        @php
                            $isResolved = $complaint->final_decision === 'resolved';
                            $theme = $isResolved ? 'green' : 'red';
                            $icon = $isResolved
                                ? '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
                                : '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
                            $statusText = $isResolved ? 'Resolved & Approved' : 'Rejected / Closed';
                        @endphp

                        <div class="bg-white overflow-hidden shadow-lg rounded-xl border-t-4 border-{{ $theme }}-500">
                            {{-- Header --}}
                            <div class="px-6 py-5 bg-{{ $theme }}-50 border-b border-{{ $theme }}-100 flex items-start sm:items-center justify-between flex-col sm:flex-row gap-4">
                                <div class="flex items-center">
                                    <div class="p-2 bg-white rounded-full text-{{ $theme }}-600 shadow-sm mr-4">
                                        {!! $icon !!}
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-{{ $theme }}-900">Case Finalized</h3>
                                        <p class="text-sm font-medium text-{{ $theme }}-700">{{ $statusText }}</p>
                                    </div>
                                </div>
                                <div class="text-xs font-bold text-{{ $theme }}-600 bg-white px-3 py-1 rounded-full border border-{{ $theme }}-200 shadow-sm">
                                    {{ $complaint->updated_at->format('M d, Y') }}
                                </div>
                            </div>

                            {{-- Body --}}
                            <div class="p-6">
                                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Official Remarks</h4>
                                <div class="bg-gray-50 rounded-lg p-5 border-l-4 border-{{ $theme }}-400 italic text-gray-700 leading-relaxed relative">
                                    <span class="absolute top-2 left-2 text-gray-300 text-4xl font-serif">"</span>
                                    {{ $complaint->office_remarks }}
                                </div>

                                @if ($complaint->office_file_path)
                                    <div class="mt-6 pt-6 border-t border-gray-100">
                                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Official Attachments</h4>
                                        <a href="{{ Storage::url($complaint->office_file_path) }}" target="_blank"
                                            class="flex items-center justify-between w-full sm:w-auto p-3 bg-white border border-gray-200 rounded-lg hover:border-{{ $theme }}-400 hover:shadow-md transition group">
                                            <div class="flex items-center">
                                                <svg class="w-8 h-8 text-{{ $theme }}-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                                <div>
                                                    <p class="text-sm font-bold text-gray-900 group-hover:text-{{ $theme }}-700">Download Response</p>
                                                    <p class="text-xs text-gray-500">Click to view document</p>
                                                </div>
                                            </div>
                                            <svg class="w-5 h-5 text-gray-300 group-hover:text-{{ $theme }}-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    {{-- 2. ORIGINAL SUBMISSION --}}
                    <div class="bg-white overflow-hidden shadow-sm rounded-xl">
                        <div class="px-6 py-5 border-b border-gray-100 bg-white">
                            <h3 class="text-lg font-bold text-gray-800">Original Submission</h3>
                        </div>
                        <div class="p-6">
                            <div class="mb-6">
                                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Subject</span>
                                <h1 class="text-xl font-bold text-gray-900">{{ $complaint->subject }}</h1>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Description</span>
                                <div class="prose max-w-none text-gray-700 leading-relaxed whitespace-pre-wrap">
                                    {{ $complaint->description }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- ========================================== --}}
                {{-- RIGHT COLUMN: SIDEBAR METADATA (1/3 Width) --}}
                {{-- ========================================== --}}
                <div class="space-y-6">

                    {{-- Status Card --}}
                    <div class="bg-white shadow-sm rounded-xl overflow-hidden p-6">
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Current Status</h4>

                        <div class="flex items-center mb-2">
                            @if ($complaint->current_status_id == 1)
                                <span class="h-3 w-3 rounded-full bg-yellow-400 mr-2"></span>
                                <span class="text-lg font-bold text-gray-800">Pending Review</span>
                            @elseif($complaint->current_status_id == 2)
                                <span class="h-3 w-3 rounded-full bg-blue-500 mr-2"></span>
                                <span class="text-lg font-bold text-gray-800">With Office</span>
                            @elseif($complaint->current_status_id == 3)
                                <span class="h-3 w-3 rounded-full bg-purple-500 mr-2 animate-pulse"></span>
                                <span class="text-lg font-bold text-gray-800">Under Review</span>
                            @elseif($complaint->current_status_id >= 4)
                                <span class="h-3 w-3 rounded-full bg-green-500 mr-2"></span>
                                <span class="text-lg font-bold text-gray-800">Closed</span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-500">
                            Last Updated: {{ $complaint->updated_at->diffForHumans() }}
                        </p>
                    </div>

                    {{-- Ticket Details --}}
                    <div class="bg-white shadow-sm rounded-xl overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                            <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wide">Ticket Info</h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <div>
                                <span class="block text-xs text-gray-400">Target Office</span>
                                <span class="block text-sm font-medium text-gray-900 mt-1">
                                    {{ $complaint->targetOffice->name ?? 'General Admin' }}
                                </span>
                            </div>
                            <div>
                                <span class="block text-xs text-gray-400">Date Filed</span>
                                <span class="block text-sm font-medium text-gray-900 mt-1">
                                    {{ $complaint->created_at->format('M d, Y') }}
                                </span>
                                <span class="block text-xs text-gray-400">
                                    {{ $complaint->created_at->format('h:i A') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Student Attachment --}}
                    @if($complaint->file_path)
                        <div class="bg-white shadow-sm rounded-xl overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                                <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wide">Your Attachment</h3>
                            </div>
                            <div class="p-6">
                                <a href="{{ Storage::url($complaint->file_path) }}" target="_blank" class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition">
                                    <div class="h-10 w-10 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center flex-shrink-0 mr-3">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                    </div>
                                    <div class="overflow-hidden">
                                        <p class="text-sm font-bold text-indigo-700 truncate">View File</p>
                                        <p class="text-xs text-gray-500">Supporting Document</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif

                </div>

            </div>
        </div>
    </div>
</x-app-layout>
