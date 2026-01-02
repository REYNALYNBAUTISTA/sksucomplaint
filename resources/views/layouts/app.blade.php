<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SCAD') }}</title>

    {{-- ✅ ADD THIS LINE --}}
    <link rel="icon" href="{{ asset('images/sksu.png') }}" type="image/png">

    <link rel="preconnect" href="https://fonts.bunny.net">
      @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">

        <div class="min-h-screen bg-gray-100 flex">

            @include('components.student-sidebar')

            <div class="flex-1 flex flex-col overflow-x-hidden">

                @isset($header)
                    <header class="bg-white shadow">
                        <div class="max-w-full mx-auto py-6 px-4 sm:px-6 lg:px-8">
                             {{ $header }}
                        </div>
                    </header>
                @endisset

                <main class="flex-1 overflow-y-auto">
                    {{ $slot }}
                </main>
            </div>
            </div>
    </body>
</html>
