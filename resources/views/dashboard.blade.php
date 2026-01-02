<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Complaints Status') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
                <div id="status-notification"
                    class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative transition-opacity duration-1000"
                    role="alert">
                    <span class="block sm:inline">{{ session('status') }}</span>
                </div>

                <script>
                    // Get the notification element
                    const notification = document.getElementById('status-notification');

                    if (notification) {
                        // 1. Wait for 3 seconds (3000 milliseconds)
                        setTimeout(() => {
                            // 2. Start the fade-out process (opacity transition defined by Tailwind classes above)
                            notification.style.opacity = '0';

                            // 3. After the fade-out completes (1000 milliseconds, matching duration-1000)
                            setTimeout(() => {
                                // 4. Finally remove the element from the DOM
                                notification.remove();
                            }, 1000);
                        }, 3000); // The time the message stays fully visible
                    }
                </script>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Recently Filed Complaints</h3>

                    @if ($complaints->isEmpty())
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                            <p class="text-sm text-blue-700">
                                You have not filed any complaints yet. Click **File New Complaint** on the sidebar to
                                start!
                            </p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Complaint ID</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Subject</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Filed To</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Current Status</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date Filed</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($complaints as $complaint)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                C-{{ $complaint->id }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">
                                                {{ $complaint->subject }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $complaint->targetOffice->name ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
    @if ($complaint->current_status_id == 1)
        {{-- Pending --}}
        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
            Pending Routing
        </span>
    @elseif($complaint->current_status_id == 2)
        {{-- Sent to Office --}}
        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
            Sent to Office
        </span>
    @elseif($complaint->current_status_id == 3)
        {{-- Action Taken (Admin Review) --}}
        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800 animate-pulse">
            Review Needed
        </span>
    @elseif($complaint->current_status_id == 4)
        {{-- Resolved --}}
        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
            Resolved
        </span>
    @elseif($complaint->current_status_id == 5)
        {{-- ✅ TARGET: Invalid / Rejected (RED) --}}
        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
            Invalid / Rejected
        </span>
    @else
        {{-- Fallback --}}
        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
            {{ $complaint->currentStatus->name ?? 'Unknown' }}
        </span>
    @endif
</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $complaint->created_at->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                @if ($complaint->current_status_id == 1)
                                                    {{-- PENDING: Allow Edit/Delete --}}
                                                    <a href="{{ route('complaint.edit', $complaint) }}"
                                                        class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</a>

                                                    <form action="{{ route('complaint.destroy', $complaint) }}"
                                                        method="POST" class="inline-block"
                                                        onsubmit="return confirm('Are you sure you want to delete this complaint?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="text-red-600 hover:text-red-900">Delete</button>
                                                    </form>
                                                @elseif ($complaint->current_status_id >= 4)
                                                    {{-- ✅ COMPLETED (Resolved OR Rejected): Show View Button --}}
                                                    <a href="{{ route('complaint.show', $complaint) }}"
                                                        class="inline-flex items-center px-3 py-1 bg-gray-100 border border-gray-300 rounded-md font-bold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 transition">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                                                            </path>
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                            </path>
                                                        </svg>
                                                        View Result
                                                    </a>
                                                @else
                                                    {{-- PROCESSING (Status 2 or 3) --}}
                                                    <span
                                                        class="text-xs text-gray-400 font-style: italic">Processing...</span>
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
