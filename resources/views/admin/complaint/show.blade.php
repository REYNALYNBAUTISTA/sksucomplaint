<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Complaint #') . $complaint->id }}
            </h2>
            <a href="{{ route('admin.complaints.index') }}"
                class="text-gray-500 hover:text-gray-700 text-sm font-medium underline">
                &larr; Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> {{-- Increased max-width slightly for better proportion --}}

            {{-- TOP STATUS BAR --}}
            <div
                class="bg-white shadow-sm sm:rounded-lg mb-6 p-4 flex items-center justify-between border-l-4
                {{ $complaint->current_status_id == 1 ? 'border-yellow-400' : ($complaint->current_status_id == 2 ? 'border-blue-500' : 'border-green-500') }}">

                <div>
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Current Status</span>
                    <div class="flex items-center mt-1">
                        @if ($complaint->current_status_id == 1)
                            <div class="h-3 w-3 rounded-full bg-yellow-400 mr-2"></div>
                            <span class="text-lg font-bold text-yellow-700">Pending Routing</span>
                        @elseif($complaint->current_status_id == 2)
                            <div class="h-3 w-3 rounded-full bg-blue-500 mr-2"></div>
                            <span class="text-lg font-bold text-blue-700">Sent to Office</span>
                        @else
                            <div class="h-3 w-3 rounded-full bg-green-500 mr-2"></div>
                            <span class="text-lg font-bold text-green-700">Resolved / Closed</span>
                        @endif
                    </div>
                </div>

                {{-- Action Button (Only if not assigned) --}}
                @if (!$complaint->assigned_office_id)
                    <a href="{{ route('admin.complaints.assign.form', $complaint) }}"
                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow-md transition text-sm">
                        Route Complaint Now &rarr;
                    </a>
                @else
                    <div class="text-right">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Assigned Office</span>
                        <p class="font-bold text-indigo-700 text-lg">{{ $complaint->assignedOffice->name }}</p>
                    </div>
                @endif
            </div>


            {{-- 3-COLUMN GRID LAYOUT --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- ================================================== --}}
                {{-- COLUMN 1: LEFT (Student & Routing)                 --}}
                {{-- ================================================== --}}
                <div class="space-y-6">

                    {{-- Student Info Card --}}
                    <div class="bg-white shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 border-b pb-2">Student
                            Information</h3>

                        <div class="flex items-center mb-4">
                            <div
                                class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-bold mr-3 text-lg">
                                {{ substr($complaint->user->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900">{{ $complaint->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $complaint->user->email }}</p>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div>
                                <span class="block text-xs text-gray-400">ID Number</span>
                                <span
                                    class="block text-sm font-medium text-gray-800">{{ $complaint->user->id_number }}</span>
                            </div>
                            <div>
                                <span class="block text-xs text-gray-400">Date Filed</span>
                                <span
                                    class="block text-sm font-medium text-gray-800">{{ $complaint->created_at->format('M d, Y, h:i A') }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Routing Details Card --}}
                    <div class="bg-white shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 border-b pb-2">Routing
                            Details</h3>

                        <div class="mb-4">
                            <span class="block text-xs text-gray-400">Student's Request</span>
                            <span class="block text-sm font-medium text-gray-800">
                                {{ $complaint->target_office_id ? \App\Models\Office::find($complaint->target_office_id)->name : 'None' }}
                            </span>
                        </div>

                        <div class="mb-4">
                            <span class="block text-xs text-gray-400">Admin Action</span>
                            @if ($complaint->assigned_office_id)
                                <span class="block text-sm font-medium text-green-600">
                                    &#10003; Routed to {{ $complaint->assignedOffice->name }}
                                </span>
                            @else
                                <span class="block text-sm font-medium text-yellow-600">
                                    &#9888; Waiting for assignment
                                </span>
                            @endif
                        </div>

                        @if ($complaint->admin_remarks)
                            <div class="mt-4 bg-yellow-50 p-3 rounded border border-yellow-100">
                                <span class="block text-xs font-bold text-yellow-800 mb-1">Admin Remarks:</span>
                                <p class="text-xs text-yellow-800 italic">"{{ $complaint->admin_remarks }}"</p>
                            </div>
                        @endif
                    </div>
                </div>


                {{-- ================================================== --}}
                {{-- COLUMN 2: CENTER (Complaint & Evidence)            --}}
                {{-- ================================================== --}}
                <div class="space-y-6">

                    {{-- Main Complaint Card --}}
                    <div class="bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-6 border-b pb-2">
                                Complaint Details
                            </h3>

                            {{-- Subject --}}
                            <div class="mb-6">
                                <span
                                    class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Subject</span>
                                <div class="text-xl font-bold text-gray-900 leading-tight">{{ $complaint->subject }}
                                </div>
                            </div>

                            {{-- Description --}}
                            <div>
                                <span
                                    class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Description</span>
                                <div
                                    class="bg-gray-50 p-4 rounded-lg border border-gray-200 text-gray-800 leading-relaxed whitespace-pre-wrap text-sm">
                                    {{ trim($complaint->description) }}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Evidence Card --}}
                    @if ($complaint->file_path)
                        <div
                            class="bg-white shadow-sm sm:rounded-lg p-6 flex flex-col items-center text-center border-t-4 border-indigo-400">
                            <svg class="w-8 h-8 text-indigo-500 mb-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-3-3v6M4 21h16a2 2 0 002-2V5a2 2 0 00-2-2H4a2 2 0 00-2 2v14a2 2 0 002 2z">
                                </path>
                            </svg>
                            <h3 class="text-md font-bold text-gray-900 mb-1">Attached Evidence</h3>
                            <p class="text-xs text-gray-500 mb-4">Student uploaded supporting file.</p>
                            <a href="{{ Storage::url($complaint->file_path) }}" target="_blank"
                                class="w-full inline-flex justify-center items-center px-4 py-2 bg-indigo-50 border border-indigo-100 rounded-md font-semibold text-xs text-indigo-700 uppercase tracking-widest hover:bg-indigo-100 transition">
                                View Document
                            </a>
                        </div>
                    @endif
                </div>


                {{-- ================================================== --}}
                {{-- COLUMN 3: RIGHT (Office Action / Result)           --}}
                {{-- ================================================== --}}
                <div class="space-y-6">

                    @if ($complaint->current_status_id > 2)

                        {{-- 1. Determine Color Theme based on Decision --}}
                        @php
                            $isRejected = $complaint->final_decision === 'rejected';
                            $theme = $isRejected ? 'red' : 'green';
                        @endphp

                        {{-- SHOW ACTION IF PROCESSED --}}
                        {{-- Card Border Color is Dynamic --}}
                        <div class="bg-white shadow-lg sm:rounded-lg border border-{{ $theme }}-200 overflow-hidden">

                            {{-- Header Background is Dynamic --}}
                            <div class="px-6 py-4 bg-{{ $theme }}-50 border-b border-{{ $theme }}-100">
                                <h3 class="text-sm font-bold text-{{ $theme }}-800 flex items-center">
                                    {{-- Icon Changes based on Decision --}}
                                    @if($isRejected)
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    @else
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    @endif
                                    Office Resolution
                                </h3>
                            </div>

                            <div class="p-6">

                                {{-- ✅ NEW: FINAL DECISION BADGE --}}
                                <div class="mb-6 border-b border-gray-100 pb-4">
                                    <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Final Decision</span>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-{{ $theme }}-100 text-{{ $theme }}-800 border border-{{ $theme }}-200 uppercase">
                                        @if($isRejected)
                                            ❌ Rejected
                                        @else
                                            ✅ Resolved
                                        @endif
                                    </span>
                                </div>

                                {{-- Date --}}
                                <div class="mb-4">
                                    <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Actioned On</span>
                                    <span class="text-sm font-semibold text-gray-800">{{ \Carbon\Carbon::parse($complaint->action_taken_at)->format('M d, Y') }}</span>
                                </div>

                                {{-- Remarks --}}
                                <div class="mb-6">
                                    <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Office Remarks</span>
                                    {{-- Remark border color is dynamic --}}
                                    <div class="p-3 bg-gray-50 rounded border-l-4 border-{{ $theme }}-400 text-sm text-gray-800 italic">
                                        "{{ $complaint->office_remarks }}"
                                    </div>
                                </div>

                                {{-- Attached Office File --}}
                                @if ($complaint->office_file_path)
                                    <div class="mb-6">
                                        <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Office Attachment</span>
                                        <a href="{{ Storage::url($complaint->office_file_path) }}" target="_blank"
                                            class="flex items-center p-3 bg-blue-50 rounded border border-blue-100 hover:bg-blue-100 transition">
                                            <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                            </svg>
                                            <span class="text-xs font-bold text-blue-700">View Response File</span>
                                        </a>
                                    </div>
                                @endif

                                {{-- NOTIFY BUTTON --}}
                                <div class="mt-6 pt-6 border-t border-gray-100">
                                    <p class="text-xs text-gray-400 mb-3 text-center">Inform the student of this result?</p>
                                    <form action="{{ route('admin.complaints.notify', $complaint) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 transition">
                                            Notify Student Email
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        {{-- PLACEHOLDER IF WAITING --}}
                        <div class="bg-gray-50 sm:rounded-lg border-2 border-dashed border-gray-300 p-6 text-center h-full flex flex-col justify-center items-center opacity-75">
                            <div class="h-12 w-12 bg-gray-200 rounded-full flex items-center justify-center mb-3">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-sm font-bold text-gray-500">Awaiting Office Action</h3>
                            <p class="text-xs text-gray-400 mt-1">The office has not processed this complaint yet.</p>
                        </div>
                    @endif

                </div>

            </div> {{-- End Grid --}}
        </div>
    </div>
</x-app-layout>
