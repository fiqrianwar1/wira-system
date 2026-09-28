<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Sembunyikan elemen x-cloak sebelum Alpine.js siap */
        [x-cloak] { display: none !important; }

        /* Custom Scrollbar Khusus Sidebar Dark Mode (Chrome, Safari, Edge) */
        .custom-scrollbar::-webkit-scrollbar {
            width: 5px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #374151;
            border-radius: 10px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background-color: #dc2626;
        }

        /* Untuk browser Firefox */
        .custom-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: #374151 transparent;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50" x-data="{ sidebarOpen: true }">

    <div class="flex min-h-screen">

        {{-- Sidebar sticky: tetap di kiri saat scroll, tidak ikut memanjang --}}
        <div class="sticky top-0 h-screen flex-shrink-0">
            @include('layouts.sidebar')
        </div>

        {{-- Area kanan: navbar sticky + konten scroll natural di body --}}
        <div class="flex-1 flex flex-col min-w-0">

            {{-- Navbar sticky di atas --}}
            <div class="sticky top-0 z-40">
                @include('layouts.navigation')
            </div>

            {{-- Konten: scroll natural, GoFullPage bisa capture sampai bawah --}}
            <main class="flex-1 bg-gray-50 p-6">
                {{ $slot }}
            </main>
        </div>
    </div>

</body>
</html>