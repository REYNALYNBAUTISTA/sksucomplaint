<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('All Complaints') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if ($complaints->isEmpty())
                        <div class="text-center py-10 text-gray-500">
                            No complaints found in the system.
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            ID</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Student</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Subject</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status</th>

                                        {{-- ✅ NEW COLUMN HEADER --}}
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Decision</th>

                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Requested Office
                                        </th>
                                        <th
                                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
    @foreach ($complaints as $complaint)
        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
            {{-- ID --}}
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                #{{ $complaint->id }}
            </td>

            {{-- Student --}}
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                {{ $complaint->user->name }}
                <div class="text-xs text-gray-400">{{ $complaint->user->id_number }}</div>
            </td>

            {{-- Subject --}}
            <td class="px-6 py-4 text-sm text-gray-700">
                {{ Str::limit($complaint->subject, 30) }}
            </td>

            {{-- Status (Updated for 5-Step Workflow) --}}
            <td class="px-6 py-4 whitespace-nowrap">
                @if ($complaint->current_status_id == 1)
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                        Pending Routing
                    </span>
                @elseif($complaint->current_status_id == 2)
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                        Sent to Office
                    </span>
                @elseif($complaint->current_status_id == 3)
                    {{-- ✅ NEW: Status 3 (Office Replied, Needs Admin) --}}
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800 animate-pulse">
                        Review Needed
                    </span>
                @elseif($complaint->current_status_id >= 4)
                    {{-- ✅ NEW: Status 4/5 (Complete) --}}
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        Completed
                    </span>
                @endif
            </td>

            {{-- Final Decision --}}
            <td class="px-6 py-4 whitespace-nowrap">
                @if ($complaint->final_decision)
                    @if ($complaint->final_decision === 'resolved')
                        <span class="px-2 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-800 uppercase border border-green-200">
                            ✅ Resolved
                        </span>
                    @elseif($complaint->final_decision === 'rejected')
                        <span class="px-2 inline-flex text-xs leading-5 font-bold rounded-full bg-red-100 text-red-800 uppercase border border-red-200">
                            ❌ Rejected
                        </span>
                    @else
                        <span class="text-xs text-gray-500 uppercase">{{ $complaint->final_decision }}</span>
                    @endif
                @else
                    <span class="text-xs text-gray-400">-</span>
                @endif
            </td>

            {{-- Target Office --}}
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ $complaint->targetOffice->name ?? 'No specific request' }}
            </td>

            {{-- Action Column --}}
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">

                {{-- View Button (Always Visible) --}}
                <a href="{{ route('admin.complaints.show', $complaint) }}"
                    class="text-gray-600 hover:text-gray-900 font-bold bg-gray-100 px-3 py-1 rounded hover:bg-gray-200 transition">
                    View
                </a>

                {{-- Logic for Other Actions --}}
                @if($complaint->current_status_id >= 4)
                    {{-- ✅ IF NOTIFIED (Status 4 or 5) --}}
                    <span class="inline-flex items-center text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded border border-green-200">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Student Notified
                    </span>

                @elseif(!$complaint->assigned_office_id)
                    {{-- IF NOT ASSIGNED YET --}}
                    <a href="{{ route('admin.complaints.assign.form', $complaint) }}"
                        class="text-indigo-600 hover:text-indigo-900 font-bold bg-indigo-50 px-3 py-1 rounded hover:bg-indigo-100 transition">
                        Route
                    </a>
                @elseif($complaint->current_status_id == 3)
                     {{-- IF PENDING REVIEW --}}
                     <span class="text-xs text-purple-600 italic">Review Pending</span>
                @endif
            </td>
        </tr>
    @endforeach
</tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $complaints->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
