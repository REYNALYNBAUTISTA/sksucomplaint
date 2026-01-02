<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Complaints Management Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- ✅ SUCCESS ALERT (Disappears after 3 seconds) --}}
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition.duration.500ms x-init="setTimeout(() => show = false, 3000)"
                    class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 shadow-sm rounded-r"
                    role="alert">
                    <div class="flex">
                        <div class="py-1">
                            <svg class="fill-current h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20">
                                <path
                                    d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM6.7 9.29L9 11.6l4.3-4.3 1.4 1.42L9 14.4l-3.7-3.7 1.4-1.42z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold">Route Successful</p>
                            <p class="text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                {{-- 1. TOTAL COMPLAINTS --}}
                <div
                    class="bg-white overflow-hidden shadow-lg rounded-lg p-6 border-l-4 border-indigo-500 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 truncate">Total Complaints</p>
                        <div class="mt-1 text-3xl font-bold text-gray-900">{{ $kpi['total_complaints'] }}</div>
                        <p class="text-xs text-gray-400 mt-1">All-time count.</p>
                    </div>
                    <div class="p-3 bg-indigo-100 rounded-full text-indigo-600">
                        {{-- Icon: Folder --}}
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                        </svg>
                    </div>
                </div>

                {{-- 2. PENDING ROUTING (New/Fresh) --}}
                <div
                    class="bg-white overflow-hidden shadow-lg rounded-lg p-6 border-l-4 border-yellow-500 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 truncate">Pending Routing</p>
                        <div class="mt-1 text-3xl font-bold text-gray-900">{{ $kpi['pending_routing'] }}</div>
                        <p class="text-xs text-gray-400 mt-1">Needs assignment.</p>
                    </div>
                    <div class="p-3 bg-yellow-100 rounded-full text-yellow-600">
                        {{-- Icon: Bell --}}
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                            </path>
                        </svg>
                    </div>
                </div>

                {{-- 3. ACTION TAKEN / WITH OFFICE --}}
                <div
                    class="bg-white overflow-hidden shadow-lg rounded-lg p-6 border-l-4 border-blue-500 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 truncate">Sent to Office</p>
                        <div class="mt-1 text-3xl font-bold text-gray-900">{{ $kpi['action_taken'] }}</div>
                        <p class="text-xs text-gray-400 mt-1">Currently being processed.</p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-full text-blue-600">
                        {{-- Icon: User Group / Office --}}
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5">
                            </path>
                        </svg>
                    </div>
                </div>

                {{-- 4. PENDING FINAL APPROVAL --}}
                <div
                    class="bg-white overflow-hidden shadow-lg rounded-lg p-6 border-l-4 border-purple-500 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 truncate">Pending Approval</p>
                        <div class="mt-1 text-3xl font-bold text-gray-900">{{ $kpi['pending_approval'] }}</div>
                        <p class="text-xs text-gray-400 mt-1">Office replied, needs check.</p>
                    </div>
                    <div class="p-3 bg-purple-100 rounded-full text-purple-600">
                        {{-- Icon: Clipboard Check --}}
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                            </path>
                        </svg>
                    </div>
                </div>

                {{-- 5. RESOLVED --}}
                <div
                    class="bg-white overflow-hidden shadow-lg rounded-lg p-6 border-l-4 border-green-500 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 truncate">Resolved</p>
                        <div class="mt-1 text-3xl font-bold text-gray-900">{{ $kpi['resolved'] }}</div>
                        <p class="text-xs text-gray-400 mt-1">Succesfully closed.</p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-full text-green-600">
                        {{-- Icon: Check Circle --}}
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>

                {{-- 6. REJECTED / INVALID --}}
                <div
                    class="bg-white overflow-hidden shadow-lg rounded-lg p-6 border-l-4 border-red-500 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 truncate">Invalid/Rejected</p>
                        <div class="mt-1 text-3xl font-bold text-gray-900">{{ $kpi['rejected'] }}</div>
                        <p class="text-xs text-gray-400 mt-1">Declined complaints.</p>
                    </div>
                    <div class="p-3 bg-red-100 rounded-full text-red-600">
                        {{-- Icon: X Circle --}}
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>

            </div>

            <div class="bg-white shadow-xl sm:rounded-lg mb-8">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2">Complaints Awaiting Routing
                        ({{ $kpi['pending_routing'] }})</h3>

                    @if ($routingComplaints->isEmpty())
                        <div class="bg-green-50 p-4 rounded-md text-sm text-green-700">No new complaints requiring
                            routing at this time.</div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            ID / Filed By</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Subject</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Filed Date</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($routingComplaints as $complaint)
                                        <tr class="hover:bg-yellow-50/50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                C-{{ $complaint->id }}<br>
                                                <span
                                                    class="text-xs text-gray-500">{{ $complaint->user->id_number }}</span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-800 max-w-xs truncate">
                                                {{ $complaint->subject }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $complaint->created_at->format('Y-m-d') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('admin.complaints.assign.form', $complaint) }}"
                                                    class="text-blue-600 hover:text-blue-900 font-semibold">
                                                    Route Complaint
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">{{ $routingComplaints->links() }}</div>
                    @endif
                </div>
            </div>

            <div class="bg-white shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2">Office Performance Overview</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Office Name</th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total Handled</th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Awaiting Action</th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Pending Routing</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($officePerformance as $office)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 font-medium text-gray-900">{{ $office->name }}</td>
                                        <td class="px-6 py-4 text-center text-gray-700 font-semibold">
                                            {{ $office->total_count }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <span
                                                class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                {{ $office->awaiting_action_count }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span
                                                class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                {{ $office->pending_routing_count }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
