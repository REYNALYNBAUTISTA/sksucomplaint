<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Office Action History') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-gray-700">Processed Complaints Log</h3>
                        <span class="text-xs text-gray-500">Showing latest {{ $history->count() }} records</span>
                    </div>

                    @if($history->isEmpty())
                        {{-- Empty State --}}
                        <div class="text-center py-12 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">No history available</h3>
                            <p class="mt-1 text-sm text-gray-500">You haven't processed any complaints yet.</p>
                        </div>
                    @else
                        {{-- History Table --}}
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Date Actioned</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Complaint ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Student</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Subject</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Decision</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Remarks</th>
                                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($history as $record)
                                        <tr class="hover:bg-gray-50 transition">

                                            {{-- Date Actioned --}}
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-bold text-gray-700">
                                                    {{ $record->action_taken_at ? \Carbon\Carbon::parse($record->action_taken_at)->format('M d, Y') : 'N/A' }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $record->action_taken_at ? \Carbon\Carbon::parse($record->action_taken_at)->format('h:i A') : '' }}
                                                </div>
                                            </td>

                                            {{-- ID --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                #{{ $record->id }}
                                            </td>

                                            {{-- Student --}}
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $record->user->name }}</div>
                                                <div class="text-xs text-gray-400">{{ $record->user->id_number }}</div>
                                            </td>

                                            {{-- Subject --}}
                                            <td class="px-6 py-4 text-sm text-gray-700">
                                                {{ Str::limit($record->subject, 20) }}
                                            </td>

                                            {{-- Decision Badge --}}
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($record->final_decision === 'resolved')
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-800 border border-green-200 uppercase">
                                                        ✅ Resolved
                                                    </span>
                                                @elseif($record->final_decision === 'rejected')
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-red-100 text-red-800 border border-red-200 uppercase">
                                                        ❌ Rejected
                                                    </span>
                                                @else
                                                    <span class="text-xs text-gray-500">-</span>
                                                @endif
                                            </td>

                                            {{-- Remarks (Truncated) --}}
                                            <td class="px-6 py-4">
                                                <div class="text-xs text-gray-600 italic max-w-xs truncate" title="{{ $record->office_remarks }}">
                                                    "{{ Str::limit($record->office_remarks, 40) }}"
                                                </div>
                                            </td>

                                            {{-- View Button --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('office.complaint.show', $record) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 px-3 py-1 rounded hover:bg-indigo-100 transition font-bold text-xs">
                                                    View Details
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        <div class="mt-4">
                            {{ $history->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
