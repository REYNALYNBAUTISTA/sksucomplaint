<div class="flex flex-col w-64 bg-white shadow-xl min-h-screen border-r border-gray-200">

    <div class="px-6 py-6 border-b border-gray-100 flex flex-col items-center text-center bg-gray-50/50">

        {{-- 1. SKSU LOGO --}}
        {{-- Make sure to upload your logo to public/images/sksu_logo.png or change the path below --}}
        <img src="{{ asset('images/sksu.png') }}"
             alt="SKSU Logo"
             class="h-20 w-20 object-contain mb-3 drop-shadow-md hover:scale-105 transition-transform duration-300">

        {{-- 2. SYSTEM NAME --}}
        <div class="space-y-1">
            <h1 class="text-2xl font-extrabold text-green-800 tracking-widest font-serif">
                SKSU
            </h1>
            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest leading-snug">
                Student Complaints &<br> Assistance Desk
            </p>
        </div>
    </div>

    <nav class="flex-1 px-4 py-4 space-y-2">

        {{-- Add PHP block to prepare for role checking --}}
        @php
            use App\Enums\Roles;
            $user = Auth::user();
        @endphp

        {{-- =============================================== --}}
        {{-- ======== ADMIN / SUPER ADMIN SIDEBAR ======== --}}
        {{-- =============================================== --}}
        @if ($user->hasRole(Roles::ADMIN->value) || $user->hasRole(Roles::SUPER_ADMIN->value))

            {{-- Admin Dashboard Link --}}
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition duration-150 ease-in-out
               {{ request()->routeIs('admin.dashboard') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37h.001z"/>
                </svg>
                Admin Dashboard
            </a>

            {{-- Complaint Management Link --}}
            <a href="{{ route('admin.complaints.index') }}"
               class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition duration-150 ease-in-out
               {{ request()->routeIs('admin.complaints.*') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2h10a2 2 0 012 2m-7 4h.01M7 16h.01"/>
                </svg>
                Complaint Management
            </a>

            {{-- === NEW: Office Management Link === --}}
            {{-- Checks if route is offices.* OR office-accounts.* so it stays active when adding new ones --}}
            <a href="{{ route('admin.offices.index') }}"
               class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition duration-150 ease-in-out
               {{ request()->routeIs('admin.offices.*') || request()->routeIs('admin.office-accounts.*') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5"/>
                </svg>
                Office Management
            </a>

            {{-- User/Office Control (Super Admin only - kept if you still want separate user management) --}}
            @if ($user->hasRole(Roles::SUPER_ADMIN->value))
                <a href="{{ route('admin.users.index') }}"
                   class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition duration-150 ease-in-out
                   {{ request()->routeIs('admin.users.*') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354l.707.707M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37h.001z"/>
                    </svg>
                    Users & Personnel
                </a>
            @endif

        {{-- =============================================== --}}
        {{-- ======== OFFICE PERSONNEL SIDEBAR ========= --}}
        {{-- =============================================== --}}
        @elseif ($user->hasRole(Roles::OFFICE_PERSONNEL->value))

            <a href="{{ route('office.dashboard') }}"
               class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition duration-150 ease-in-out
               {{ request()->routeIs('office.dashboard') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-2.81a2 2 0 00-.737-1.161V7a2 2 0 00-2-2H9a2 2 0 00-2 2v6.029a2 2 0 00-.737 1.161L4 17h5m6 0v2m0 0h-6"/>
                </svg>
                Office Queue
            </a>

            <a href="{{ route('office.history') }}"
               class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition duration-150 ease-in-out
               {{ request()->routeIs('office.history') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v4.244m0 0a2 2 0 110 4m0-4a2 2 0 100-4m0 4v.001"/>
                </svg>
                Action History
            </a>

        {{-- =============================================== --}}
        {{-- ========== STUDENT / DEFAULT SIDEBAR ========== --}}
        {{-- =============================================== --}}
        @else

            {{-- My Complaints (Student Dashboard) --}}
            <a href="{{ route('dashboard') }}"
               class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition duration-150 ease-in-out
               {{ request()->routeIs('dashboard') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
                My Complaints
            </a>

            {{-- File New Complaint --}}
            <a href="{{ route('complaint.create') }}"
               class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition duration-150 ease-in-out
               {{ request()->routeIs('complaint.create') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-3-3v6M4 21h16a2 2 0 002-2V5a2 2 0 00-2-2H4a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
                File New Complaint
            </a>

        @endif

        <div class="pt-6 border-t border-gray-100">
            {{-- Profile Settings Link (Common to all roles) --}}
            <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-50 transition duration-150 ease-in-out">
                 <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Profile Settings
            </a>
        </div>
    </nav>

    <div class="p-4 border-t border-gray-200">
        <div class="flex items-center space-x-3 mb-4">
            <div class="h-10 w-10 flex items-center justify-center bg-gray-200 text-gray-700 font-bold rounded-full">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div>
                <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center py-2 px-4 text-sm font-medium rounded-lg text-red-600 border border-red-50 hover:bg-red-50 transition duration-150 ease-in-out">
                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Logout
            </button>
        </form>
    </div>
</div>
