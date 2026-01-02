<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $officeName }} {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- ======================== --}}
            {{-- KPI STATS CARDS          --}}
            {{-- ======================== --}}
            {{-- KPI CARDS GRID --}}
{{-- KPI CARDS GRID --}}
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">

    {{-- 1. AWAITING ACTION (Yellow) --}}
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 border-l-4 border-yellow-500 flex flex-col justify-between">
        <div class="flex justify-between items-start">
            <div>
                <div class="text-xs font-bold text-gray-500 uppercase tracking-wider">Awaiting</div>
                <div class="text-2xl font-extrabold text-gray-900 mt-1">{{ $awaitingCount }}</div>
            </div>
            <div class="p-2 bg-yellow-100 rounded-full text-yellow-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>

    {{-- 2. PROCESSED / REVIEW (Blue) --}}
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 border-l-4 border-blue-500 flex flex-col justify-between">
        <div class="flex justify-between items-start">
            <div>
                <div class="text-xs font-bold text-gray-500 uppercase tracking-wider">In Review</div>
                <div class="text-2xl font-extrabold text-gray-900 mt-1">{{ $processedCount }}</div>
            </div>
            <div class="p-2 bg-blue-100 rounded-full text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
            </div>
        </div>
    </div>

    {{-- 3. RESOLVED (Green) --}}
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 border-l-4 border-green-500 flex flex-col justify-between">
        <div class="flex justify-between items-start">
            <div>
                <div class="text-xs font-bold text-gray-500 uppercase tracking-wider">Resolved</div>
                <div class="text-2xl font-extrabold text-gray-900 mt-1">{{ $resolvedCount }}</div>
            </div>
            <div class="p-2 bg-green-100 rounded-full text-green-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>

    {{-- 4. REJECTED (Red) --}}
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 border-l-4 border-red-500 flex flex-col justify-between">
        <div class="flex justify-between items-start">
            <div>
                <div class="text-xs font-bold text-gray-500 uppercase tracking-wider">Rejected</div>
                <div class="text-2xl font-extrabold text-gray-900 mt-1">{{ $rejectedCount }}</div>
            </div>
            <div class="p-2 bg-red-100 rounded-full text-red-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>

    {{-- 5. TOTAL (Indigo) --}}
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 border-l-4 border-indigo-500 flex flex-col justify-between">
        <div class="flex justify-between items-start">
            <div>
                <div class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total</div>
                <div class="text-2xl font-extrabold text-gray-900 mt-1">{{ $totalComplaints }}</div>
            </div>
            <div class="p-2 bg-indigo-100 rounded-full text-indigo-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
        </div>
    </div>

</div>

            {{-- ======================== --}}
            {{-- INCOMING TABLE           --}}
            {{-- ======================== --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold text-gray-700 mb-4 border-b pb-2">Incoming Complaints Queue</h3>

                    @if ($complaints->isEmpty())
                        <div class="text-center py-12 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                            <div
                                class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">All caught up!</h3>
                            <p class="mt-1 text-sm text-gray-500">No active complaints assigned to your office.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                            ID / Date</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                            Student</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                            Subject</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                            Status</th>
                                        {{-- ✅ NEW COLUMN --}}
                                        <th
                                            class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                            Decision</th>
                                        <th
                                            class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($complaints as $complaint)
                                        <tr class="hover:bg-gray-50 transition duration-150">
                                            {{-- ID / Date --}}
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-bold text-indigo-600">#{{ $complaint->id }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $complaint->created_at->format('M d, Y') }}</div>
                                            </td>

                                            {{-- Student --}}
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $complaint->user->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $complaint->user->id_number }}
                                                </div>
                                            </td>

                                            {{-- Subject --}}
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900 font-medium">
                                                    {{ Str::limit($complaint->subject, 30) }}</div>
                                            </td>

                                            {{-- Status --}}
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if ($complaint->current_status_id == 2)
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 animate-pulse">
                                                        Awaiting Action
                                                    </span>
                                                @else
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        Processed
                                                    </span>
                                                @endif
                                            </td>

                                            {{-- ✅ NEW COLUMN: FINAL DECISION --}}
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if ($complaint->final_decision)
                                                    @if ($complaint->final_decision === 'resolved')
                                                        <span
                                                            class="px-2 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-800 uppercase border border-green-200">
                                                            ✅ Resolved
                                                        </span>
                                                    @elseif($complaint->final_decision === 'rejected')
                                                        <span
                                                            class="px-2 inline-flex text-xs leading-5 font-bold rounded-full bg-red-100 text-red-800 uppercase border border-red-200">
                                                            ❌ Rejected
                                                        </span>
                                                    @endif
                                                @else
                                                    <span class="text-xs text-gray-400 font-medium">-</span>
                                                @endif
                                            </td>

                                            {{-- Action Button --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('office.complaint.show', $complaint) }}"
                                                    class="inline-flex items-center px-3 py-1 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none transition ease-in-out duration-150">
                                                    {{ $complaint->final_decision ? 'View' : 'Process' }}
                                                    <svg class="ml-2 -mr-0.5 h-4 w-4" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                                    </svg>
                                                </a>
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
